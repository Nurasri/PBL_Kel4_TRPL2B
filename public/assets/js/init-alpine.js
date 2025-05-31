function data() {
  return {
    // Sidebar states
    isSideMenuOpen: false,
    isSidebarCollapsed: false,
    
    // Profile menu state
    isProfileMenuOpen: false,
    
    // Notification menu state
    isNotificationMenuOpen: false,
    
    // Dark mode state
    dark: false,
    
    // Sidebar functions
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    
    toggleSidebar() {
      this.isSidebarCollapsed = !this.isSidebarCollapsed
    },
    
    // Profile menu functions
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
      this.isNotificationMenuOpen = false; // Close notification when opening profile
    },
    
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
    
    // Notification menu functions
    toggleNotificationMenu() {
      this.isNotificationMenuOpen = !this.isNotificationMenuOpen
      this.isProfileMenuOpen = false; // Close profile when opening notification
    },
    
    closeNotificationMenu() {
      this.isNotificationMenuOpen = false
    },
    
    // Dark mode toggle
    toggleTheme() {
      this.dark = !this.dark
      localStorage.setItem('theme', this.dark ? 'dark' : 'light')
    },
    
    // Initialize theme from localStorage
    initTheme() {
      const savedTheme = localStorage.getItem('theme')
      if (savedTheme) {
        this.dark = savedTheme === 'dark'
      } else {
        this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches
      }
    }
  }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  // Any additional initialization can go here
})
