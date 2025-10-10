<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectText }}</title>
</head>
<body style="font-family: 'Poppins', sans-serif; background-color: #f9f9ff; color: #333; padding: 30px;">

    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

        <div style="background-color: #713899; color: #fff; text-align: center; padding: 20px;">
            <h1 style="margin: 0;">CloseSeller</h1>
        </div>

        <div style="padding: 30px;">
            <h2 style="color: #333;">{{ $subjectText }}</h2>
            <div style="font-size: 15px; line-height: 1.6; color: #555;">
                {!! $body !!}
            </div>

            <p style="font-size: 16px; margin-top: 30px; font-weight: 600;">
                Regards,<br>
                <span style="color: #713899;">The CloseSeller Team</span>
            </p>
        </div>

        <div style="background-color: #f1f0ff; text-align: center; padding: 15px;">
            <small style="color: #777;">&copy; {{ date('Y') }} CloseSeller. All rights reserved.</small>
        </div>

    </div>

</body>
</html>
