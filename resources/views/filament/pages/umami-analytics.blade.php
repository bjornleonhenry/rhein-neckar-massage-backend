<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Umami Analytics Embed -->
        <x-filament::section>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg" style="padding: 1rem;">
                <div class="w-full" style="height: calc(100vh - 2rem);">
                    <iframe 
                        style="min-height: 100vh;"
                        src="https://cloud.umami.is/share/IegbsPQlTFGTBTJX" 
                        class="w-full h-full rounded-lg border-0"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
                 <div class="mt-4 flex items-center justify-between">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <x-filament::icon icon="heroicon-o-information-circle" class="h-4 w-4" />
                        Live data from Umami Analytics
                    </p>
                    <a href="https://cloud.umami.is/share/IegbsPQlTFGTBTJX" 
                       target="_blank" 
                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" class="h-4 w-4 mr-2" />
                        Open in New Tab
                    </a>
                 </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>