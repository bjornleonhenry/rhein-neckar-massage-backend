<?php

namespace Filaforge\DatabaseQuery\Pages;

use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class DatabaseQuery extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationLabel = 'Database Querys';

    protected static ?string $title = 'Database Query';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    protected string $view = 'database-query::pages.database-query';

    public array $data = [];

    public ?string $queryResult = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        $connections = $this->getAvailableConnections();

        return $schema
            ->components([
                Select::make('connection')
                    ->label('Database Connection')
                    ->options($connections)
                    ->default(config('database.default')),

                Select::make('preset_query')
                    ->label('Preset Queries')
                    ->placeholder('Select a preset query...')
                    ->options(fn () => $this->getPresetQueries())
                    ->reactive()
                    ->afterStateUpdated(function ($state) {
                        if ($state) {
                            $this->data['sql'] = $state;
                            $this->data['preset_query'] = null;
                        }
                    }),

                Textarea::make('sql')
                    ->label('SQL Query')
                    ->placeholder('SELECT * FROM users LIMIT 10 | INSERT INTO users... | UPDATE users SET... | DELETE FROM users... | CREATE TABLE... | DROP TABLE...')
                    ->rows(6)
                    ->helperText('ALL SQL commands allowed: SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, TRUNCATE, SHOW, DESCRIBE, EXPLAIN, transactions, etc.'),
            ])
            ->statePath('data');
    }

    public function executeQuery(): void
    {
        $sql = trim($this->data['sql'] ?? '');

        if (empty($sql)) {
            Notification::make()->title('SQL query is required')->danger()->send();

            return;
        }

        // All SQL commands are now allowed - no security restrictions

        try {
            $connection = $this->getConnectionName();
            $db = DB::connection($connection);

            // Determine query type and execute accordingly
            $sqlUpper = strtoupper(trim($sql));

            // Queries that return result sets
            $resultQueries = ['SELECT', 'SHOW', 'DESCRIBE', 'DESC', 'EXPLAIN', 'PRAGMA', 'WITH'];

            // Check if query starts with any result-returning command
            $isResultQuery = false;
            foreach ($resultQueries as $cmd) {
                if (str_starts_with($sqlUpper, $cmd)) {
                    $isResultQuery = true;

                    break;
                }
            }

            if ($isResultQuery) {
                // Queries that return results
                $results = $db->select($sql);
                $this->queryResult = empty($results) ? 'Query executed successfully. No results returned.' : $this->formatQueryResults($results);
            } else {
                // Queries that don't return results (INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, TRUNCATE, etc.)
                $affected = $db->statement($sql);
                $this->queryResult = "Query executed successfully.\n\nAffected rows: " . $affected;
            }

            Notification::make()->title('Query executed successfully')->success()->send();
        } catch (QueryException $e) {
            $this->queryResult = 'Error: ' . $e->getMessage();
            Notification::make()->title('Query failed')->body($e->getMessage())->danger()->send();
        }
    }

    protected function getAvailableConnections(): array
    {
        $connections = [];
        $databaseConfig = config('database.connections', []);
        foreach ($databaseConfig as $name => $config) {
            if (isset($config['driver'])) {
                $connections[$name] = ucfirst($name) . ' (' . $config['driver'] . ')';
            }
        }

        return $connections;
    }

    protected function getConnectionName(): string
    {
        return $this->data['connection'] ?? config('database.default');
    }

    protected function getPresetQueries(): array
    {
        $connection = $this->getConnectionName();
        $driverName = config("database.connections.{$connection}.driver", 'mysql');

        $queries = [];
        if ($driverName === 'sqlite') {
            $queries["SELECT name FROM sqlite_master WHERE type='table' ORDER BY name"] = 'List all tables';
        } elseif ($driverName === 'mysql') {
            $queries['SHOW TABLES'] = 'List all tables';
        } elseif ($driverName === 'pgsql') {
            $queries["SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename"] = 'List all tables';
        }
        // Data Query Language (DQL)
        $queries['SELECT * FROM users LIMIT 10'] = 'Show first 10 users';
        $queries['SELECT COUNT(*) as total FROM users'] = 'Count all users';
        $queries['SELECT * FROM users WHERE email LIKE "%@example.com"'] = 'Filter users by email';
        $queries['SELECT u.*, COUNT(o.id) as order_count FROM users u LEFT JOIN orders o ON u.id = o.user_id GROUP BY u.id'] = 'Users with order count';

        // Data Manipulation Language (DML)
        $queries['INSERT INTO users (name, email, created_at) VALUES ("Test User", "test@example.com", NOW())'] = 'Insert new user';
        $queries['UPDATE users SET updated_at = NOW() WHERE id = 1'] = 'Update user timestamp';
        $queries['DELETE FROM users WHERE id = 999'] = 'Delete user (safe - non-existent ID)';
        $queries['REPLACE INTO users (id, name) VALUES (999, "Replaced User")'] = 'Replace user record';

        // Data Definition Language (DDL)
        $queries['CREATE TABLE test_table (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)'] = 'Create test table';
        $queries['ALTER TABLE users ADD COLUMN test_column VARCHAR(100)'] = 'Add column to users table';
        $queries['DROP TABLE IF EXISTS test_table'] = 'Drop test table (safe)';
        $queries['TRUNCATE TABLE test_table'] = 'Clear all data from table';

        // Database Administration
        $queries['SHOW TABLES'] = 'List all tables';
        $queries['SHOW COLUMNS FROM users'] = 'Show users table structure';
        $queries['DESCRIBE users'] = 'Describe users table (alternative)';
        $queries['SHOW INDEX FROM users'] = 'Show table indexes';
        $queries['SHOW CREATE TABLE users'] = 'Show table creation SQL';

        // Transaction Control
        $queries['BEGIN'] = 'Start transaction';
        $queries['COMMIT'] = 'Commit transaction';
        $queries['ROLLBACK'] = 'Rollback transaction';

        // Advanced Queries
        $queries['EXPLAIN SELECT * FROM users'] = 'Explain query execution plan';
        $queries['WITH RECURSIVE cte AS (SELECT 1 as n UNION ALL SELECT n+1 FROM cte WHERE n < 5) SELECT * FROM cte'] = 'Recursive CTE example';

        // MySQL-specific commands
        $queries['INSERT IGNORE INTO users (name, email) VALUES ("Test", "test@example.com")'] = 'Insert user (ignore duplicates)';
        $queries['INSERT INTO users (name, email) VALUES ("Test", "test@example.com") ON DUPLICATE KEY UPDATE name = "Updated"'] = 'Insert or update user';
        $queries['REPLACE INTO users (id, name) VALUES (999, "Replaced")'] = 'Replace user record';
        $queries['CREATE TEMPORARY TABLE temp_users AS SELECT * FROM users LIMIT 5'] = 'Create temporary table';
        $queries['DROP TEMPORARY TABLE IF EXISTS temp_users'] = 'Drop temporary table';
        $queries['LOCK TABLE users WRITE'] = 'Lock table for writing';
        $queries['UNLOCK TABLES'] = 'Unlock all tables';
        $queries['OPTIMIZE TABLE users'] = 'Optimize table performance';
        $queries['ANALYZE TABLE users'] = 'Analyze table for query optimizer';
        $queries['CHECK TABLE users'] = 'Check table integrity';
        $queries['REPAIR TABLE users'] = 'Repair corrupted table';
        $queries['SELECT * FROM information_schema.tables WHERE table_schema = DATABASE()'] = 'List tables using information schema';

        return $queries;
    }

    private function formatQueryResults(array $results): string
    {
        if (empty($results)) {
            return 'No results found.';
        }

        $first = (array) $results[0];
        $columns = array_keys($first);
        $columnWidths = [];
        foreach ($columns as $column) {
            $columnWidths[$column] = max(strlen($column), 10);
        }
        $displayResults = array_slice($results, 0, 100);
        foreach ($displayResults as $row) {
            $rowArray = (array) $row;
            foreach ($columns as $column) {
                $value = $rowArray[$column] ?? '';
                $displayValue = $value === null ? 'NULL' : (string) $value;
                $columnWidths[$column] = max($columnWidths[$column], strlen($displayValue));
            }
        }
        foreach ($columnWidths as $column => $width) {
            $columnWidths[$column] = min($width, 50);
        }
        $output = 'Query Results (' . count($results) . ")\n\n";
        $headerParts = [];
        $separatorParts = [];
        foreach ($columns as $column) {
            $width = $columnWidths[$column];
            $headerParts[] = str_pad($column, $width);
            $separatorParts[] = str_repeat('─', $width);
        }
        $output .= '┌─' . implode('─┬─', $separatorParts) . "─┐\n";
        $output .= '│ ' . implode(' │ ', $headerParts) . " │\n";
        $output .= '├─' . implode('─┼─', $separatorParts) . "─┤\n";
        foreach ($displayResults as $row) {
            $rowArray = (array) $row;
            $valueParts = [];
            foreach ($columns as $column) {
                $value = $rowArray[$column] ?? '';
                $displayValue = $value === null ? 'NULL' : (string) $value;
                if (strlen($displayValue) > $columnWidths[$column]) {
                    $displayValue = substr($displayValue, 0, $columnWidths[$column] - 3) . '...';
                }
                $valueParts[] = str_pad($displayValue, $columnWidths[$column]);
            }
            $output .= '│ ' . implode(' │ ', $valueParts) . " │\n";
        }
        $output .= '└─' . implode('─┴─', $separatorParts) . "─┘\n";
        if (count($results) > 100) {
            $output .= "\n... and " . (count($results) - 100) . " more rows (showing first 100)\n";
        }

        return $output;
    }
}
