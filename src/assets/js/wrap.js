import baseURL from './baseURL'

export default {
  status(e) {
    const status = {
      0: 'Disapproved',
      1: 'Approved',
      2: 'Undecided',
      3: 'Not yet submitted'
    }
    
    return status[e]
  },
  fileSize(num) {
    let n = Number(num)
    if (n >= 1000 * 1000 * 1000) {
      return (n / 1000 / 1000 / 1000).toFixed(2) + ' GB'
    } else if (n >= 1000 * 1000) {
      return (n / 1000 / 1000).toFixed(2) + ' MB'
    } else if (n >= 1000) {
      return (n / 1000).toFixed(2) + ' KB'
    }
    return n + ' bytes'
  },

  fullname(user, mname) {
    return user.name

    if (typeof user !== 'object') {
      return ''
    }
    if (typeof mname !== 'boolean') {
      mname = true
    }
    
    let fullname = user.fname + ' '
    fullname += mname && user.mname ? user.mname + ' ' : ''
    fullname += user.lname

    return fullname
  },
  localImg(url) {
    return baseURL + 'uploads/images/' + url
  }
}
