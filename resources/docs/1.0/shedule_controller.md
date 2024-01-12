# Introduction

> This documentation outlines the SheduleController's functionalities and APIs available in our application.

> Users can run the shedule manually

## Base URL

All endpoints are relative to the base URL of your Laravel application.

---

# Authentication

To access these endpoints, authentication is required. Use appropriate tokens or authentication mechanisms to access the endpoints.

> to authnticate the request every request should be bind with  `bearer token`

> Admin authentication is required for CREATE, DELETE and UPDATE endpoints.

---

# Endpoint

> This endpoint triggers a scheduled task to remind users about uncompleted breakdown records older than 2 days. It performs the following steps:
> 
> 1. Retrieves uncompleted breakdown records older than 2 days using the `BreakdownStatus` model.
> 2. Fetches email addresses of users authorized at level 2 for carbon copy purposes via the `EmailCarbonCopyPerson` model.
> 3. Sends reminder emails to the specified recipients, composing the email content based on the retrieved breakdown records and related information.
> 4. Generates a response containing the status of the scheduled task, the IDs of sent records, and the list of email recipients.


## Retrieve All
perform sheduled task manully

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/manual/late_alert | Accept: application/json |

### Response
Successful run of shedule.

```json
{
    "status": 200,
    "message": "Sheduled Task Executed.",
    "records": [1, 2, 3],
    "mail_list": ["email1@example.com", "email2@example.com"]
}
```

---

# Models Used
## BreakdownStatus Model
Represents the status of breakdown records in the system.

## EmailCarbonCopyPerson Model
Stores email addresses and authorization levels for carbon copy purposes.

---

# External Dependency
## PHPMailerController
> Handles the composition and sending of emails. This controller is utilized to send reminder emails to the specified recipients based on the retrieved breakdown records.

---

# Error Handling
Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.