<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense ID {{ $expense->id }}</title>
</head>
<body>
    <table cellspacing="0" cellpadding="3" width="100%" border="1">
        <tr>
            <td>
                <strong>Categories</strong>
            </td>
        </tr>
        <tr>
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
            <td>
                <strong>Recipient</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $expense->recipient }}</td>
        </tr>

        <tr>
            <td>
                <strong>Description</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $expense->description ?? '-' }}</td>
        </tr>

        <tr>
            <td>
                <strong>Approvals</strong>
            </td>
        </tr>
        <tr>
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

        <tr>
            <td>
                <strong>Created At</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $expense->created_at }}</td>
        </tr>

        <tr>
            <td>
                <strong>Last Updated</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $expense->updated_at }}</td>
        </tr>
    </table>
</body>
</html>
