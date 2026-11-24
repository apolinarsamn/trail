<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRAIL Membership Application Received</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f5f2ec; color: #1b2920; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f5f2ec;">
        <tr>
            <td align="center" style="padding: 32px 16px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width: 100%; max-width: 600px; overflow: hidden; border: 1px solid #d9dfd3; border-radius: 18px; background-color: #fffefa;">

                    <tr>
                        <td align="center" style="padding: 34px 30px; background-color: #163a2b;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="border-radius: 12px; background-color: #fffefa;">
                                <tr>
                                    <td style="padding: 13px 24px;">
                                        <img
                                            src="{{ url('images/TRAIL LOGO.png') }}"
                                            alt="TRAIL Outdoor Club"
                                            width="180"
                                            style="display: block; width: 180px; max-width: 100%; height: auto; border: 0;"
                                        >
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 22px 0 0; color: #dce47c; font-size: 11px; font-weight: 700; letter-spacing: 1.8px; text-transform: uppercase;">
                                Outdoor Recreation Membership
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 38px 38px 20px;">
                            <p style="margin: 0 0 12px; color: #54724f; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;">
                                Application received
                            </p>

                            <h1 style="margin: 0; color: #163a2b; font-family: Georgia, 'Times New Roman', serif; font-size: 32px; font-weight: 500; line-height: 1.2;">
                                Thanks for joining us, {{ $application->full_name }}!
                            </h1>

                            <p style="margin: 18px 0 0; color: #69736b; font-size: 15px; line-height: 1.7;">
                                We received your TRAIL membership application. Our team will review your details and contact you regarding payment and the next approval steps.
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 28px; border: 1px solid #d9dfd3; border-radius: 12px; background-color: #f8faf5;">
                                <tr>
                                    <td style="padding: 22px;">
                                        <p style="margin: 0 0 16px; color: #163a2b; font-size: 15px; font-weight: 700;">
                                            Application summary
                                        </p>

                                        <p style="margin: 0 0 6px; color: #69736b; font-size: 12px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">
                                            Reference number
                                        </p>

                                        <p style="margin: 0 0 18px; color: #163a2b; font-family: monospace; font-size: 15px; font-weight: 700;">
                                            {{ $application->reference_no }}
                                        </p>

                                        @if ($membershipCategory)
                                            <p style="margin: 0 0 6px; color: #69736b; font-size: 12px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">
                                                Membership selection
                                            </p>

                                            <p style="margin: 0 0 18px; color: #163a2b; font-size: 15px; font-weight: 700;">
                                                {{ $membershipCategory->name }}
                                            </p>
                                        @endif

                                        <p style="margin: 0 0 6px; color: #69736b; font-size: 12px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">
                                            Current status
                                        </p>

                                        <p style="margin: 0; color: #1f7a46; font-size: 15px; font-weight: 700;">
                                            Pending review
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top: 28px; padding: 20px; border-radius: 12px; background-color: #edf3e9;">
                                <p style="margin: 0 0 8px; color: #163a2b; font-size: 15px; font-weight: 700;">
                                    What happens next?
                                </p>

                                <ol style="margin: 0; padding-left: 19px; color: #69736b; font-size: 14px; line-height: 1.8;">
                                    <li>Our team reviews your application details.</li>
                                    <li>We contact you regarding the membership fee and payment process.</li>
                                    <li>Once payment is verified, your membership can be approved.</li>
                                </ol>
                            </div>

                            <p style="margin: 28px 0 0; color: #69736b; font-size: 14px; line-height: 1.7;">
                                Please keep your reference number for future inquiries.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 24px 30px; border-top: 1px solid #d9dfd3; background-color: #fffefa;">
                            <a href="{{ url('/') }}" style="color: #163a2b; font-size: 14px; font-weight: 700; text-decoration: none;">
                                Explore TRAIL →
                            </a>

                            <p style="margin: 14px 0 0; color: #8a938c; font-size: 12px; line-height: 1.6;">
                                TRAIL Outdoor Club<br>
                                Membership for people who choose the outdoors.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>