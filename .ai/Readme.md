# Multi-Agent Development

***

## General Concept

The system consists of a team of specialized agents coordinated by an orchestrator.
Each agent performs a specific role in the development process.

The orchestrator manages the work sequence, transfers results between agents, and stops the process
when blocking questions arise.

***

## Agent Roles

### Orchestrator

**Function:**

- Coordination of the entire development process
- Assigns tasks to other agents
- Receives and analyzes results
- Determines next steps
- Stops the process when blocking questions arise
- Manages review-refinement cycles

### Product Owner

**Function:** [Describing business needs and planning epic stages](/.ai/agents/Stage0CreateEpic.md)

### Business Analyst

**Function:** [Describing business requirements](/.ai/agents/Stage1CreateSpec.md)

### System Analyst + IT Architect

**Function:** [Forming a summary technical plan](/.ai/agents/Stage2CreatePlanSummary.md)

### System Analyst + PHP Developer

**Function:** [Forming a technical plan for code development](/.ai/agents/Stage2CreatePlanDev.md)

### System Analyst + Test Developer

**Function:** [Forming a technical plan for writing tests](/.ai/agents/Stage2CreatePlanTest.md)

### PHP Developer

**Function:** [Software code development](/.ai/agents/Stage3Implementation.md)

### Test Developer

**Function:** [Test development](/.ai/agents/Stage4Testing.md)

### Technical Writer

**Function:** [Creating technical documentation](/.ai/agents/Stage5TechDoc.md)

### IT Architect

**Function:** [Creating architectural documentation](/.ai/agents/Stage6ArchDoc.md)

***

## Workflow Scheme

At each stage of multi-agent development, the steps for working with agents will be the same:

1. Create a new context in "**orchestrator**" mode and write a command to it (see description of each stage).
2. Conduct a review, make corrections yourself or give a command to the agent for corrections.
3. Make a commit yourself or give the command: `make a commit`.
   The command to the agent should be given in the "**orchestrator**" task so that the agent, having the general context, can correctly
   compose the commit comment.

### Workflow

- Step 0 is executed first, where the epic and stages are created.
- Step 1 is repeated as many times as stages were created.
- Step 2 is repeated for each stage immediately before implementation.
- Since the technical plan is also divided into sub-stages, Steps 3-6 are repeated for each sub-stage.
- In Step 7, human-readable documentation is created.
- In Step 8, architectural documentation is created describing the interaction and dependencies of the entire system.

## Recommendations

If the task is not large, creating an epic is not mandatory. You can immediately create a specification with a description of
business requirements.

After creating the epic, create **only specifications** for each stage.
Create technical plans immediately before starting implementation.

Creating technical plans "for the future" leads to the fact that after completing the current stage, you have to
reconsider the implementation plan for the next stage.

To reduce context and simplify code review, the technical plan is also divided into several implementation sub-stages
+ separately code development and test writing.

## Work Sequence

### Step 0. Describing business requirements and planning epic stages

Command: `/ra-epic <epic number> <description of business needs>`

Algorithm: [ra-epic.md](/.ai/commands/ra-epic.md)

### Step 1. Describing functional requirements

Command: `/ra-spec <task number> <path to epic Summary.md> <stage number>`

Algorithm: [ra-spec.md](/.ai/commands/ra-spec.md)

### Step 2. Forming a summary technical plan

**Recommendation**: create the technical plan immediately before development.
Creating a plan "for the future" leads to the fact that after implementing the current stage, you have to
reconsider the development plan for the next stage.

Command: `/ra-plan-sum <path to task Spec.md>`

Algorithm: [ra-plan-sum.md](/.ai/commands/ra-plan-sum.md)

### Step 3. Forming a technical plan for code development

Command: `/ra-plan-dev <path to task folder> <stage number>`

Algorithm: [ra-plan-dev.md](/.ai/commands/ra-plan-dev.md)

### Step 4. Forming a technical plan for writing tests

Command: `/ra-plan-test <path to task folder> <stage number>`

Algorithm: [ra-plan-test.md](/.ai/commands/ra-plan-test.md)

### Step 5. Software code development

Command: `/ra-impl <path to task Task.md> <implementation stage number>`

Algorithm: [ra-impl.md](/.ai/commands/ra-impl.md)

Conduct a review, make corrections yourself or give a command to the agent for corrections.
Make a commit yourself or give the command: `make a commit`.

### Step 6. Writing tests

Command: `/ra-test <path to task Task.md> <implementation stage number>`

Algorithm: [ra-test.md](/.ai/commands/ra-test.md)

Conduct a review, make corrections yourself or give a command to the agent for corrections.
Make a commit yourself or give the command: `make a commit`.

### Step 7. Creating technical documentation

Command: `/ra-tech-doc <path to task folder>`

Algorithm: [ra-tech-doc.md](/.ai/commands/ra-tech-doc.md)

### Step 8. Creating architectural documentation

Command: `/ra-arch-doc <path to task folder>`

Algorithm: [ra-arch-doc.md](/.ai/commands/ra-arch-doc.md)
