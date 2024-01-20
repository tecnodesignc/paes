export interface User {
  id: number,
  firstName: string,
  lastName: string,
  fullName: string,
  email: string,
  avatar: string,
  isActivated: boolean,
  permissions: [],
  lastLogin: string,
  roles: [],
  token: string
}

export interface Notification {
  id: number,
  user_id: number,
  type: string,
  message: string,
  icon_class: string,
  link: string,
  is_read: boolean,
  title: string
}

export interface Vehicle {
  id: number,
  brand: string,
  plate: string,
  model: string,
  class: string,
  capacity: number,
  millage: number,
  companyId: string,
  type: string,
  reference: string,
  propertyCard: string
}
