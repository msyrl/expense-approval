<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense ID {{ $expense->id }}</title>
    <style>
        .v-align-top {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <table cellspacing="0" cellpadding="5" width="100%" border="1">
        <tr>
            <td colspan="2" style="text-align: center;">
                <strong>{{ config('app.long_name') }}</strong>
            </td>
        </tr>

        <tr>
            <td class="v-align-top" width="150px">
                <strong>Categories</strong>
            </td>
            <td>
                <table cellspacing="0" cellpadding="0" width="100%">
                    @foreach ($expense->categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}. {{ $category->name }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>

        <tr>
            <td class="v-align-top">
                <strong>Recipient</strong>
            </td>
            <td>{{ $expense->recipient }}</td>
        </tr
        >
        <tr>
            <td class="v-align-top">
                <strong>Amount</strong>
            </td>
            <td>{{ $expense->amount_with_separator }}</td>
        </tr>

        <tr>
            <td class="v-align-top">
                <strong>Description</strong>
            </td>
            <td>{{ $expense->description ?? '-' }}</td>
        </tr>

        <tr>
            <td class="v-align-top">
                <strong>Approvals</strong>
            </td>
            <td>
                <table cellspacing="0" cellpadding="0" width="100%">
                    @foreach ($expense->approvals as $index => $approval)
                        <tr>
                            <td>
                                <span>{{ $index + 1 }}. {{ $approval->user->name }} -</span>
                                @switch($approval->approval_status->id)
                                    @case(App\Models\ApprovalStatus::WAITING)
                                        <strong>{{ $approval->approval_status->name }}</strong>
                                        @break

                                    @case(App\Models\ApprovalStatus::APPROVED)
                                        <strong style="color: green">{{ $approval->approval_status->name }} | {{ $approval->updated_at }}</strong>
                                        @break

                                    @case(App\Models\ApprovalStatus::REJECTED)
                                        <strong style="color: red">{{ $approval->approval_status->name }} | {{ $approval->updated_at }}</strong>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
