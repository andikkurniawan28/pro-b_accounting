<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ENV("APP_NAME") }}</title>
    <link href="/sbadmin2/css/invoice.css" rel="stylesheet">
</head>
<body>
    <div>
        <div class="py-4">
            <div class="px-14 py-6">
                <table class="w-full border-collapse border-spacing-0">
                    <tbody>
                        <tr>
                            <td class="w-full align-top">
                                <div>
                                    <img src="https://raw.githubusercontent.com/templid/email-templates/main/templid-dynamic-templates/invoice-02/brand-sample.png"
                                        class="h-12" />
                                </div>
                            </td>

                            <td class="align-top">
                                <div class="text-sm">
                                    <table class="border-collapse border-spacing-0">
                                        <tbody>
                                            <tr>
                                                <td class="border-r pr-4">
                                                    <div>
                                                        <p class="whitespace-nowrap text-slate-400 text-right">Date</p>
                                                        <p class="whitespace-nowrap font-bold text-main text-right">
                                                            {{ date('d F Y', strtotime($journal->date)) }}</p>
                                                    </div>
                                                </td>
                                                <td class="pl-4">
                                                    <div>
                                                        <p class="whitespace-nowrap text-slate-400 text-right">Journal #
                                                        </p>
                                                        <p class="whitespace-nowrap font-bold text-main text-right">
                                                            {{ $journal->code }}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-100 px-14 py-6 text-sm">
                <table class="w-full border-collapse border-spacing-0">
                    <tbody>
                        <tr>
                            <td class="w-1/2 align-top">
                                <div class="text-sm text-neutral-600">
                                    <p class="font-bold">{{ $setting->company_name }}</p>
                                    <p>Number: {{ $setting->company_phone }}</p>
                                    <p>Email: {{ $setting->company_email }}</p>
                                    <p>{{ $setting->company_street }}</p>
                                    <p>{{ $setting->company_city_and_province }}</p>
                                    <p>{{ $setting->company_country }}</p>
                                </div>
                            </td>
                            <td class="w-1/2 align-top text-right">
                                <div class="text-sm text-neutral-600">

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-14 py-10 text-sm text-neutral-700">
                <table class="w-full border-collapse border-spacing-0">
                    <thead>
                        <tr>
                            <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
                            <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">
                                {{ ucwords(str_replace('_', ' ', 'code')) }}</td>
                            <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">
                                {{ ucwords(str_replace('_', ' ', 'account')) }}</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">
                                {{ ucwords(str_replace('_', ' ', 'description')) }}</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">
                                {{ ucwords(str_replace('_', ' ', 'debit')) }}<sub>({{ $setting->currency->symbol }})</sub>
                            </td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">
                                {{ ucwords(str_replace('_', ' ', 'credit')) }}<sub>({{ $setting->currency->symbol }})</sub>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journal->journal_entry as $entry)
                            <tr>
                                <td class="border-b py-3 pl-3">{{ $loop->iteration }}</td>
                                <td class="border-b py-3 pl-2">{{ $entry->account->code }}</td>
                                <td class="border-b py-3 pl-2">{{ $entry->account->name }}</td>
                                <td class="border-b py-3 pl-2 text-right">{{ $entry->description }}</td>
                                <td class="border-b py-3 pl-2 text-center">
                                    {{ $entry->debit == 0 ? '-' : number_format($entry->debit, 2, $setting->decimal_separator, $setting->thousand_separator) }}
                                </td>
                                <td class="border-b py-3 pl-2 text-center">
                                    {{ $entry->credit == 0 ? '-' : number_format($entry->credit, 2, $setting->decimal_separator, $setting->thousand_separator) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="bg-main p-3" colspan="4">
                                <div class="whitespace-nowrap font-bold text-white">
                                    Total:</div>
                            </td>
                            <td class="bg-main p-3 text-center">
                                <div class="whitespace-nowrap font-bold text-white">
                                    {{ number_format($journal->debit, 2, $setting->decimal_separator, $setting->thousand_separator) }}
                                </div>
                            </td>
                            <td class="bg-main p-3 text-center">
                                <div class="whitespace-nowrap font-bold text-white">
                                    {{ number_format($journal->credit, 2, $setting->decimal_separator, $setting->thousand_separator) }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-14 text-sm text-neutral-700">
                <!-- <p class="text-main font-bold">PAYMENT DETAILS</p>
                <p>Banks of Banks</p>
                <p>Bank/Sort Code: 1234567</p>
                <p>Account Number: 123456678</p>
                <p>Payment Reference: BRA-00335</p> -->
            </div>

            <div class="px-14 py-10 text-sm text-neutral-700">
                <p class="text-main font-bold">Notes</p>
                <p class="italic">Recorded by {{ $journal->user->name }} on {{ $journal->created_at }} ({{ $journal->id }}).</p>
                </dvi>

                <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
                    {{ $setting->company_name }}
                    <span class="text-slate-300 px-2">|</span>
                    {{ $setting->company_email }}
                    <span class="text-slate-300 px-2">|</span>
                    {{ $setting->company_phone }}
                    <span class="text-slate-300 px-2">|</span>
                    <button onclick="window.print()" class="px-4 py-2 bg-blue-500 text-black rounded">Print</button>
                </footer>
            </div>
        </div>
</body>

</html>
