# Instructor Solution Notes

This file deliberately avoids copying a complete final solution. Use it as the grading map.

Expected fixes:
1. MaintenanceRequest::customer() must be belongsTo(Customer::class).
2. Store validation must validate all required fields and foreign keys.
3. Store must persist the full validated payload.
4. Index must implement search and filters and preserve them in pagination.
5. Authorization must be enforced for view/update/delete.
6. Technician must not edit another technician's request.
7. Delete must be admin-only.
8. Rating must only be allowed for completed requests and must belong to the request's customer.
9. Duplicate ratings must be prevented.
10. API must return sensible JSON and 404 for missing records.
11. Eager loading should be retained.
12. Surprise task varies per student.
