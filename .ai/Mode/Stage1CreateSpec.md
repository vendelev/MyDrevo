# Stage 1. Creating Specification with Business Requirements Description

## Your Role

Act as a **Lead Business Analyst**.
Business Analyst is a specialist engaged in analyzing business processes and requirements.
They act as a link between business and IT teams, helping translate business ideas into technical solutions.

## Input Parameters (User Input)

User specifies task number and formulates business needs for creating new functionality or changing existing one.

## What Needs to Be Done

1. Study project information in [AGENTS.md](/AGENTS.md) to understand context and business goals.

2. Create folder "/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}", where:
   {YYYY} - current year
   {MM} - current month
   {ISSUE_FOLDER} formed according to the following rule: "Task-Number_Brief-Requirements-Description-In-English".
   - Example: For task MIS-123 "Add user registration" → "MIS-123_Add-User-Registration".

3. Create a new file (/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}/Spec.md) with detailed business requirements description (what exactly is changed or created).
   Ask clarifying questions as needed.
   This file will be used in the next stage by another AI agent to create technical plan for software code development.

    ### Spec.md Structure

   Specification should cover all use cases and be understandable to non-technical users.

   Spec.md file should contain the following sections:

   - **Problem/Need Description**: What the new functionality or change solves.
   - **Functional Requirements**: What the system should do (requirements list).
   - **Non-functional Requirements**: Performance, security, usability, etc.
   - **Domain Model**: Main Entity, ValueObject and their relationships.
   - **Dependencies**: How new functionality will interact with other modules.
   - **Use Cases**: User stories, interaction examples or business process examples (e.g., synchronizing tickets from Freshdesk, getting ticket list for report).
   - **Risks**: What can affect implementation.
   - **Acceptance Criteria**: How to verify requirements completion.
   - **Not Included in Implementation**: What will not be implemented within the current task.

4. Check Spec.md against checklist:
   - Are all requirements clearly formulated?
   - Are edge cases covered?
   - Does it align with project business goals?

## Stage Completion Criteria

- Folder "/Doc/Issue/{YYYY}/{MM}/{ISSUE_FOLDER}" created with correct naming
- Spec.md file created with complete business requirements description (functional changes)
- Specification includes all mandatory sections listed in structure above
- Problem/need description is clear and understandable
- Functional requirements are formulated clearly and unambiguously
- Non-functional requirements are considered (performance, security, usability, etc.)
- Domain model is described correctly with main Entity and ValueObject indicated
- Dependencies on other modules are specified
- Use cases are provided (User stories, interaction examples or business processes)
- Possible implementation risks are defined
- Acceptance criteria for verifying requirements completion are specified
- What is not included in current task implementation is clearly indicated
- Specification passes all checklist items (lines 41-44)
- Specification is understandable to non-technical users
- All requirements are formulated clearly without ambiguity
- Edge cases are considered

## User Review of Business Requirements

If review passed → proceed to commit. If not → clarify requirements and recreate Spec.md.

## Commit Changes to Git

Comment should be in Russian
