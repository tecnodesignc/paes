import { defineStore } from 'pinia'
import { server } from 'src/boot/axios'
import { useUserStore } from 'stores/user-store'

export const useVehicleStore = defineStore('vehicles', {
  state: () => ({
    vehicles: [],
    vehicle: null
  }),
  getters: {
    getVehicles: (state) => state.vehicles,
    getVehicle: (state) => state.vehicle
  },
  actions: {
    async loadVehicles () {
      try {
        await server.get(`/transport/v1/vehicles?company_id=${useUserStore.company.id}&include=company&take100,page=1`).then(response => {
          const vehicles = response.data
          console.log(vehicles, 'actions')
          this.setVehicles(vehicles)
        })
      } catch (e) {
        if (e) {
          throw e
        }
      }
    },
    async selectVehicle (vehicle: never) {
      this.setVehicle(vehicle)
    },
    setVehicles (payload: any) {
      console.log(payload, 'payload')
      if (payload.data) this.vehicles = payload.data
    },
    setVehicle (payload: any) {
      console.log(payload, 'payload')
      if (payload.data) this.vehicle = payload.data
    },
    clearVehicles () {
      this.vehicles = []
      this.vehicle = null
    }

  },
  persist: true
})
