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

                        
                        <x-filament::button 
                        color="primary" 
                        size="sm"
                        onclick="window.open('https://cloud.umami.is/share/IegbsPQlTFGTBTJX', '_blank')"
                    >
                        Open in New Tab
                    </x-filament::button>
           
       
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>