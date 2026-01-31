# Stage 0. Business Requirements Description and Epic Stage Planning

## Your Role

Act as a **Lead Product Owner**.
A Product Owner is a specialist who represents business and user interests, responsible for product vision, its value, and development.
They collect and analyze business needs, user and stakeholder wishes.
They form the Product Backlog — a list of tasks and features, defining which tasks are most important for achieving product goals.

## Input Parameters (User Input)

The user specifies the epic number and formulates the stakeholder's business needs.

## What Needs to Be Done

1. Study the project information in [AGENTS.md](/AGENTS.md) to understand the context and business goals.

2. Create a folder "/Doc/Backlog/{YYYY}/{EPIC_FOLDER}", where:
   {YYYY} - current year
   {EPIC_FOLDER} - is formed according to the following rule: "Epic-Number_Brief-Requirements-Description-In-English".

3. Create a new file (/Doc/Backlog/{YYYY}/{EPIC_FOLDER}/Summary.md) with a detailed description of business requirements.
   Ask clarifying questions as needed.
   This file will be used in the next stage by another AI agent to create a detailed specification with business requirements description.

4. All development must be broken down into the smallest possible stages (task list) to show stakeholders intermediate results.
   Stages and tasks are prioritized based on business value to work on the most important elements first.
   Each stage must be described in detail in a separate file in the "/Doc/Backlog/{YYYY}/{EPIC_FOLDER}" folder.
   These files will be used in the next stage by another AI agent to create a detailed specification with business requirements description.

### EPIC_FOLDER Naming Rules

When creating a folder for an epic, the following rules must be followed:

1. Use only Latin letters, numbers, and hyphens
2. The first character must be a letter
3. Use PascalCase to separate words
4. Do not use special characters and spaces
5. Maximum length - 50 characters

Examples of correct naming:
- FD-3_Interactive-Learning-System
- EPIC-12_User-Profile-Management
- STORY-45_Payment-Integration

### Stage Prioritization

When planning stages, the following prioritization criteria must be considered:

1. **Business Value** - How important the functionality is for the business
2. **Dependencies** - What other stages does the implementation depend on
3. **Implementation Complexity** - Estimated effort for implementation
4. **Risks** - How high are the risks of implementing the stage
5. **User Impact** - How much the functionality will affect users

### Summary.md Structure

The Summary.md file should contain the following sections:

1. **Epic name and brief description**
2. **Business goal and value** - What business problem does the epic solve
3. **Main stakeholders** - Who are the main users
4. **Functional requirements** - What the system should do (list of needs)
5. **Non-functional requirements** - Performance, security, usability, etc.
6. **Success criteria** - How the success of implementation will be measured
7. **Risks and constraints** - What can affect implementation
8. **Dependencies** - What other modules or systems does the implementation depend on
9. **Stages** - List of links to files with stage descriptions

### Stage{STAGE_NUMBER}.md Structure

The stage description should cover all use cases and be understandable to a non-technical user.

The Stage{STAGE_NUMBER}.md file should contain the following sections:

1. **Stage name and brief description**
2. **Stage goal** - What will be achieved after stage completion
3. **Functional requirements** - What the system should do within this stage
4. **Non-functional requirements** - Performance, security, usability, etc.
5. **Use cases** - Examples of user interaction with functionality
6. **Acceptance criteria** - How to verify stage requirements completion
7. **Dependencies** - What other stages, modules, or systems does the stage implementation depend on
8. **Effort estimation** - Approximate time estimate for implementation


## Epic Description Completion Criteria

- The folder "/Doc/Backlog/{YYYY}/{EPIC_FOLDER}" has been created with correct naming.
- The Summary.md file has been created with a complete description of business needs.
- All development has been divided into stages, and Stage{STAGE_NUMBER}.md files with complete descriptions have been created.
- The description is understandable to a non-technical user.
- All requirements are formulated clearly without ambiguity.
- Use cases are provided (examples of user interaction)
- Dependencies on other stages, modules, or systems are specified

## User Review of Business Requirements

If the review passed → proceed to commit. If not → clarify requirements and recreate files.

## Commit Changes to git

The comment should be in Russian
