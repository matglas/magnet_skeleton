# Purpose
The purpose of the core module is to have one place to depend all neccesary
contribs. Its still discussible to do it differently but this is the reason:

- The profile dependencies are enabled last.
- The module dependencies are enable in order of dependency.
- If features are enabled before contrib are enabeld they are reverted every
  time a module is beeing enabled. This is very resource intensive.

# Reminders
- Only put functionality in this core module that should run in all circumstances.
  Don't create spageti code.
- All modules that should be installed before everything else is run, should go
  in here as a dependency.