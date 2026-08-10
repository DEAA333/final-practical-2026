# Instructor Guide

## Purpose

This project is deliberately designed so that AI assistance can be permitted without making understanding irrelevant.

Recommended grading:
- 80 points implementation
- 10 points oral explanation
- 10 points live modification

## Intentional issues

The starter version contains controlled issues in:
1. one relationship
2. one mass-assignment configuration
3. one authorization gap
4. one validation gap
5. one inefficient query path
6. one route/API omission
7. one Blade edge case
8. one rating business-rule gap

Do not reveal these locations to students.

## Suggested surprise tasks

Assign one per student:
A. Add a phone-number search.
B. Filter unassigned requests.
C. Add dashboard counts.
D. Prevent deleting customers that have requests.
E. Add sorting by newest/oldest/priority.
F. Restrict technician dashboard to assigned requests.
G. Add delete confirmation.
H. Add a simple status summary card.

## AI-dependence indicators

Do not penalize AI use by itself. Investigate when:
- the student cannot explain a submitted relationship or policy;
- the student cannot fix a small error live;
- the student cannot explain validation rules;
- code contains large unrelated generated sections;
- the student cannot explain why eager loading is used;
- the student cannot trace a request from route -> controller -> model -> view.

## Suggested oral questions

1. Why is MaintenanceRequest belongsTo Customer?
2. Why does User use technician_id for the request relationship?
3. What does eager loading solve?
4. What is mass assignment?
5. Why use findOrFail?
6. How do you prevent one technician from editing another technician's request?
7. Where should business authorization live?
8. What happens when customer_id does not exist?
9. Why is the rating unique per maintenance request?
10. Explain one randomly selected line from your code.
