const msgs = {
  required: 'This field is required.',
  requiredArray: 'This field is required.',
  min: 'Minimum is ',
  max: 'Maximum is ',
  email: 'Invalid email.',
  chars: 'Invalid value.',
  chars8: 'Requires 8 or more characters.',
  password: 'Requires 6 to 13 characters.',
  match: 'Value does not match.',
  nonExisting: 'This already exists.',
  duplicateEmail: 'This email already exists.'
}

let rules = {
  required: (msg) => (e) => !!e || msg,
  requiredArray: (msg) => (e) => e.length > 0 || msg,
  min: (msg, min) => (e) => (e !== null && e >= min) || (msg + min),
  max: (msg, max) => (e) => (e !== null && e <= max) || (msg + max),
  email: (msg) => (e) => {
    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return pattern.test(e) || msg
  },
  chars: (msg, n) => (e) => (e ? e.length >= n : false) || msg,
  chars8: (msg) => (e) => (e ? e.length >= 8 : false) || msg,
  password: (msg) => (e) => (e && e.length >= 6 && e.length <= 13) || msg,
  match: (msg, match) => (e) => e == match || msg,
  nonExisting: (msg, arr) => (e) => {
    if (!arr) { return true }
    return arr.indexOf(e) == -1 || msg
  },
  duplicateEmail: (msg, val) => (e) => {
    let cond = typeof val === 'boolean' ? !val : false
    return cond ? true : msg
  }
}

export default function(rule, msg, param) {
  msg = msg ? msg : msgs[rule]
  return rules[rule](msg, param)
}
