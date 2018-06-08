const production = process.env.NODE_ENV === 'production'
const forceDev = true

export default forceDev || !production ?
  'http://localhost/xlinkcode/public/' :
  'http://linkcode.x10.mx/'
