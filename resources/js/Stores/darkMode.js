import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useDarkModeStore = defineStore('darkMode', () => {
  const isEnabled = ref(false)

  function set(payload = false) {
    isEnabled.value = payload !== null ? payload : !isEnabled.value

    localStorage.setItem('darkMode', isEnabled.value ? '1' : '0')

    if (typeof document !== 'undefined') {
      document.body.classList[isEnabled.value ? 'add' : 'remove']('dark-scrollbars')

      document.documentElement.classList[isEnabled.value ? 'add' : 'remove'](
        'dark',
        'dark-scrollbars-compat'
      )
    }
  }

  return {
    isEnabled,
    set
  }
})
