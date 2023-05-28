import Cookies from 'universal-cookie'

const accessToken = 'accessToken'
const selectedDevices = 'selected'
const authen2fa = 'authen2fa'

export function getAccessToken() {
  return new Cookies().get(accessToken)
}

export function setAccessToken(token, options = {}) {
  return new Cookies().set(accessToken, token, options)
}

export function removeAccessToken(options = {}) {
  if (getAccessToken()) {
    return new Cookies().remove(accessToken, options)
  }
}

export function getSelectedDevices() {
  return new Cookies().get(selectedDevices)
}

export function setSelectedDevices(deviceId) {
  const devices = getSelectedDevices()

  const options = {
    expires: new Date(Date.now() + 3600000),
    path: '/',
  }

  if (!devices) {
    return new Cookies().set(selectedDevices, [deviceId], options)
  } else if (devices.find((id) => id == deviceId)) {
    return
  } else {
    return new Cookies().set(selectedDevices, [...devices, deviceId], options)
  }
}

export function removeSelectedDevices(id = null) {
  const devices = getSelectedDevices()

  if (devices) {
    if (id && devices.length > 1) {
      const filteredDevices = devices.filter((deviceId) => deviceId != id)

      const options = {
        expires: new Date(Date.now() + 3600000),
        path: '/',
      }

      return new Cookies().set(selectedDevices, filteredDevices, options)
    } else {
      return new Cookies().remove(selectedDevices, {
        path: '/',
      })
    }
  }
}

export function getAuthen2fa() {
  return new Cookies().get(authen2fa)
}

export function setAuthen2fa(value, options = {}) {
  return new Cookies().set(authen2fa, value, options)
}

export function removeAuthen2fa() {
  if (getAuthen2fa()) {
    return new Cookies().remove(authen2fa, {
      path: '/',
    })
  }
}