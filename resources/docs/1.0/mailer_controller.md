- [Introduction](#Introduction-link)
- [Methods](#Methods-link)
- [External Dependencies Used](#External-link)
- [Error Handling](#Error-link)

<a name="Introduction-link">
# [Introduction](#Introduction-link)

> This controller manages email functionalities utilizing the PHPMailer library.
> Methods
- Test Endpoint for Email Functionality
- compose, and send emails method

<a name="Methods-link">
# [Methods](#Methods-link)
>
## Compose and Send Emails
> Constructs and sends an email using PHPMailer.

### Parameters
- `$to` (Required): Email recipient address.
- `$cc` (Optional): Array of CC recipient addresses.
- `$bcc` (Optional): Array of BCC recipient addresses.
- `$subject` (Required): Email subject.
- `$body` (Required): Email body content.

> {info.fa-lightbulb} This method does not have API endpoint.

## Test

> All endpoints are relative to the base URL of your Laravel application.

| Method | URI | Headers |
| : |   :   | : |
| POST | /api/sendmail | Accept: application/json |

> {danger.fa-lightbulb} This Endpoint is not active by default. to enable please uncomment the code line of the relevent route under Test category of `routes/api.php`

### Request Body

```json
{
    "to": "string (email, Required)",
    "cc": [
        "string (email, Optional)",
        "string (email, Optional)"
    ],
    "bcc": [
        "string (email, Optional)",
        "string (email, Optional)"
    ],
    "subject": "string (Required)"
}
```
---

<a name="External-link">
# [External Dependencies Used](#External-link)
>
## PHPMailer Library

PHPMailer is utilized for email functionality within the application. It provides a flexible and secure means of sending emails via various transport methods.

- **Library Version**: 6.8
- **Purpose**: Used for composing, formatting, and sending emails through SMTP or other mail transfer protocols.
- **Usage**: Integrated within the `PHPMailerController` to manage email-related functionalities.

### Gmail SMTP Configuration

The application relies on Gmail's SMTP server to send emails.

- **SMTP Host**: smtp.gmail.com
- **SMTP Port**: 465 (SSL encryption)
- **Authentication**: Enabled
- **SMTPSecure**: ssl
- **Sender Email**: aps.cc.peoplesbank@gmail.com
- **Password**: Please Check the relevent codeline

> {danger.fa-lightbulb} Although `ssl` for `SMTPSecure` is required in Gmail. This might cause malfuctions in other mail systems.

### Views and Templates

- **Email Templates**: Views (`test_email`, `email`) used for composing email content.
- **Inline Image**: Signature image (`sig.jpg`) attached to emails using PHPMailer's `addEmbeddedImage()` method. Image path is `public/images/sig.jpg`.

---

<a name="Error-link">
# [Error Handling](#Error-link)

Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.