import { defineStore } from 'pinia'
import { server } from 'src/boot/axios'

export const useUserStore = defineStore('user', {
  state: () => ({
    id: null,
    firstName: null,
    lastName: null,
    fullName: null,
    email: null,
    avatar: null,
    isActivated: null,
    permissions: [],
    lastLogin: null,
    roles: [],
    company: null,
    identification: null,
    token: null,
    csrfToken: null
  }),
  getters: {
    getId: (state) => state.id,
    getFirstName: (state) => state.firstName,
    getLastName: (state) => state.lastName,
    getFullName: (state) => state.fullName,
    getEmail: (state) => state.email,
    getAvatar: (state) => state.avatar,
    getIsActivated: (state) => state.isActivated,
    getPermissions: (state) => state.permissions,
    getLastLogin: (state) => state.lastLogin,
    getRoles: (state) => state.roles,
    getCompany: (state) => state.company,
    getIdentification: (state) => state.identification,
    getToken: (state) => state.token,
    getCsrfToken: (state) => state.csrfToken
  },
  actions: {
    async login (email: any, password: any) {
      try {
        await server.post('/auth/login', { email: email, password: password }).then(response => {
          const user = response.data.data
          this.setUser(user)
          server.defaults.headers.common.Authorization = 'Bearer ' + user.token
        })
      } catch (e) {
        if (e) {
          throw e
        }
      }
    },
    async register (data: any) {
      try {
        await server.post('/auth/register', data)
      } catch (e) {
        if (e) throw e
      }
    },
    async logout () {
      try {
        await server.get('/auth/logout').then(() => {
          this.clearUser()
          server.defaults.headers.common.Authorization = null
        })
      } catch (e) {
        if (e) throw e
      }
    },
    setUser (payload: any) {
      if (payload.id) this.id = payload.id
      if (payload.first_name) this.firstName = payload.first_name
      if (payload.last_name) this.lastName = payload.last_name
      if (payload.full_name) this.fullName = payload.full_name
      if (payload.email) this.email = payload.email
      if (payload.avatar) this.avatar = payload.avatar
      if (payload.is_activated) this.isActivated = payload.is_activated
      if (payload.permissions) this.permissions = payload.permissions
      if (payload.last_login) this.lastLogin = payload.last_login
      if (payload.roles) this.roles = payload.roles
      if (payload.company) this.company = payload.company
      if (payload.identification) this.identification = payload.identification
      if (payload.token) this.token = payload.token
      if (payload.csrf_token) this.csrfToken = payload.csrf_token
    },
    clearUser () {
      this.id = null
      this.firstName = null
      this.lastName = null
      this.fullName = null
      this.email = null
      this.avatar = null
      this.isActivated = null
      this.permissions = []
      this.lastLogin = null
      this.roles = []
      this.company = null
      this.identification = null
      this.token = null
      this.csrfToken = null
    }

  },
  persist: true
})
