# Task Manager - Changelog

## Added Features (December 03, 2024)

### Task Progress Visualization
- Added a dynamic progress bar for each task
- Progress bar shows elapsed time from creation to deadline
- Color coding:
  - Red: Elapsed time portion
  - Blue: Remaining time portion
  - Green: Completed tasks
- Shows start date, end date, and days remaining

### Task List Management
- Added ability to edit task lists
- Added description field for task lists
- Added delete functionality with confirmation dialog
- Added tooltips for edit and delete actions

### Task Management
- Added ability to edit individual tasks
  - Can modify task title
  - Can change priority level
  - Can update deadline
- Edit form maintains dark mode support
- Added validation for edited tasks
  - Prevents past dates for deadlines
  - Requires all fields to be filled
- Added edit button with icon for better UX

### Task Requirements
- Made deadline field mandatory for new tasks
- Added validation to prevent past dates
- Added custom error messages for invalid dates

### Search and Filter System
- Added real-time search functionality for tasks
- Search maintains cursor focus after results update
- Case-insensitive search that filters as you type
- 300ms debounce to optimize performance

### Task Sorting and Filtering
- Added sorting options:
  - By deadline (default)
  - By priority (High → Medium → Low)
  - By completion status
- Added filtering options:
  - All tasks
  - Pending tasks only
  - Completed tasks only
- Sort and filter selections persist with search

### Search Improvements
- Fixed special characters handling in search functionality
  - Problem: Special characters (+, #, %, &) were being ignored in search because they weren't properly URL-encoded
  - Solution: Added encodeURIComponent() to properly encode special characters before sending the search request
  - Example: Now searching for "c+" correctly finds "c++" and filters out "c" and "cd"
  - Affected characters: +, #, %, &, and other URL-special characters
- Improved search UX with stable viewport position
  - Problem: Page would jump when tasks were filtered during search
  - Solution: Implemented dynamic height preservation during search operations
  - Maintains viewport position when:
    - Tasks are filtered out during search
    - Tasks reappear when clearing search
  - Result: Smoother user experience with no page jumping during search

### UI Improvements
- Implemented dark mode support throughout
- Mobile-friendly responsive design
- Centered navigation and content
- Improved spacing and layout
- Added visual feedback for task status

## Technical Details
- Using Laravel for backend
- Tailwind CSS for styling
- MySQL database
- Real-time search with JavaScript
- Blade templates for views
