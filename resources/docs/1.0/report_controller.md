- [Introduction](#Introduction-link)
- [Endpoint](#Endpoint-link)
- [Functionality Overview](#Functionality-link)
- [Dependencies Used](#Dependencies-link)
- [Error Handling](#Error-link)

<a name="Introduction-link">
# [Introduction](#Introduction-link)

> The `ReportController` facilitates the generation of a PDF report detailing frequent breakdowns based on specified criteria within the system. This documentation outlines the available endpoint, its functionalities, and usage.

## Base URL

All endpoints are relative to the base URL of your Laravel application.

---

# Authentication

To access these endpoints, authentication is required. Use appropriate tokens or authentication mechanisms to access the endpoints.

> to authnticate the request every request should be bind with  `bearer token`

> User authentication is required Generate Report.

---

<a name="Endpoint-link">
# [Endpoint](#Endpoint-link)
> 
## Generate PDF Report of Frequent Breakdowns
> Generates a PDF report detailing breakdowns that occur a specified number of times within a given date range.

| Method | URI | Headers |
| : |   :   | : |
| POST | /api/reports/frequents/pdf | Accept: application/pdf |

### Request Body
```json
{
    "find": "mid | tid", // Field to search (string)
    "times": "integer", // Number of occurrences (integer)
    "date_from": "YYYY-MM-DD | null", // Start date of the range (string | null)
    "date_to": "YYYY-MM-DD | null", // End date of the range (string | null)
    "order_by_1": "mid | tid | merchant | null", // First order field (string | null)
    "order_by_2": "mid | tid | merchant | null", // Second order field (string | null)
    "order_by_1_order": "ASC | DESC", // Order for the first field (string)
    "order_by_2_order": "ASC | DESC" // Order for the second field (string)
}
```
### Response
> Type : `File/PDF`
> Name : `Frequent_Breakdowns.pdf`
> Page Size : `A4`
> Oriantation : `portrait` 


<a name="Functionality-link">
# [Functionality Overview](#Functionality-link)

 - Receives a POST request with specific parameters to generate a PDF report of frequent breakdowns.
 - Validates the incoming request data to ensure correctness and completeness.
 - Constructs a database query to fetch breakdown records meeting the specified criteria (occurrences, date range, ordering).
 - Retrieves breakdown records from the database based on the constructed query.
 - Prepares the fetched data along with report metadata for PDF generation.
 - Generates a PDF report using the fetched data and metadata.
 - Initiates the download of the generated PDF file as a response to the request.


<a name="Dependencies-link">
# [Dependencies Used](#Dependencies-link)

 - Laravel's Request Handling: Utilizes Illuminate\Http\Request for handling incoming HTTP requests and validating request data.
 - PDF Generation: Relies on a PDF generation library or package (PDF) to create PDF reports.
 - Database Querying: Uses Laravel's DB facade for custom SQL queries.

---

<a name="Error-link">
# [Error Handling](#Error-link)

Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.