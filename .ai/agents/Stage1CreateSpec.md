# Stage 1. Functional Requirements Description

## Your Role

Act as a **Lead Business Analyst**.
A Business Analyst is a specialist who deals with analyzing business processes and requirements.
They serve as a liaison between the business and IT teams, helping to translate business ideas into technical solutions.

## Input Parameters (User Input)

The user specifies the task number and formulates business needs for creating new functionality or modifying existing functionality.

## What Needs to Be Done

1. Study the project information in [AGENTS.md](/AGENTS.md) to understand the context and business goals.

2. Create a folder "/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}", where:
   {YYYY} - current year
   {MM} - current month
   {ISSUE_FOLDER} is formed according to the following rule: "Task-Number_Brief-Description-Of-Requirements-In-English".
   - Example: For task MIS-123 "Add user registration" → "MIS-123_Add-User-Registration".

3. Create a new file (/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md) with a detailed description of business requirements (what exactly is being changed or created).
   Ask clarifying questions as needed.
   This file will be used at the next stage by another AI agent to create a technical plan for software code development.

   ### Spec.md Structure

   The specification should cover all use cases and be understandable to a non-technical user.

   The Spec.md file should contain the following sections:

   - **Problem/Need Description**: What the new functionality or change solves.
   - **Functional Requirements**: What the system should do (list of requirements).
   - **Non-Functional Requirements**: Performance, security, usability, etc.
   - **Domain Model**: Core Entities, ValueObjects and their relationships.
   - **Dependencies**: How the new functionality will interact with other modules.
   - **Use Case Scenarios**: User stories, interaction examples or business process examples (e.g., synchronizing tickets from Freshdesk, getting a list of tickets for a report).
   - **Risks**: What might affect implementation.
   - **Acceptance Criteria**: How to verify that requirements are met.
   - **Out of Scope**: What will not be implemented as part of the current task.

4. Check Spec.md against the checklist:
   - Are all requirements clearly formulated?
   - Are edge cases covered?
   - Does it align with the project's business goals?

## Stage Completion Criteria

- Created folder "/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}" with correct naming
- Created Spec.md file with complete description of business requirements (functional changes)
- Specification includes all mandatory sections listed in the structure above
- Problem/need description is clear and understandable
- Functional requirements are formulated clearly and unambiguously
- Non-functional requirements are considered (performance, security, usability, etc.)
- Domain model is described correctly with indication of core Entities and ValueObjects
- Dependencies on other modules are specified
- Use case scenarios are provided (User stories, interaction examples or business processes)
- Potential implementation risks are identified
- Acceptance criteria are specified for verifying requirement fulfillment
- Clearly defined what is out of scope for the current task
- Specification passes verification against all checklist items (lines 41-44)
- Specification is understandable to a non-technical user
- All requirements are formulated clearly without ambiguity
- Edge cases are considered

## User Review of Business Requirements

If review is approved → proceed to commit. If not → clarify requirements and recreate Spec.md.

## Commit Changes to Git

Comment should be in Russian
