<div>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="mb-6">
            <label for="domains" class="block text-sm font-medium text-gray-700">
                Введите домены (по одному на строку):
            </label>
            <textarea
                id="domains"
                wire:model="domains"
                rows="5"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="example.com&#10;example.org"
            ></textarea>
        </div>

        <button
            wire:click="checkDomains"
            wire:loading.attr="disabled"
            class="inline-flex items-center px-4 py-2 bg-indigo-300 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
            <span wire:loading.remove class="text-black">Проверить домены</span>
            <span wire:loading class="text-black">Проверка...</span>
        </button>

        @if (!empty($results))
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Результаты:</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Домен
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Доступность
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Дата истечения
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach ($results as $result)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $result['domain'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if (isset($result['available']))
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $result['available'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $result['available'] ? 'Доступен' : 'Недоступен' }}
                                            </span>
                                    @else
                                        <span class="text-gray-500">Ошибка</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{
                                        $result['expiresDate']
                                        ? (strtotime($result['expiresDate']) !== false
                                            ? date('Y-m-d H:i:s', strtotime($result['expiresDate']))
                                            : 'Неизвестно')
                                        : 'Неизвестно'
                                    }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
