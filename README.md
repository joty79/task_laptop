# Task Manager - Changelog

## Added Features (March 21, 2024)

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
