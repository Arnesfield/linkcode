const production = process.env.NODE_ENV === 'production'
const forceDev = true

export default forceDev || !production ?
  'http://localhost:8080/xlinkcode/public/' :
  'to be set'
