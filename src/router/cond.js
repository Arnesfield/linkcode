import toNumberArray from '@/assets/js/toNumberArray'

export default function(router, http, bus) {

  let beforeEach = function(to, from, next) {
    // set title
    const title = to.meta.title || to.name

    // do loading
    bus.refresh(true)

    // convert to array
    let toAuth = toNumberArray(to.meta.auth)
    let sessAuth = toNumberArray(bus.session.auth)

    const nonauth = [0, -1]
    const auth = [1, 3, 4, 5, 6]

    const SESS_EXISTS = bus.authHas(sessAuth, auth)
    const TO_HAS_SESS = bus.authHas(toAuth, sessAuth, -1)
    const IS_ADMIN = bus.authHas(sessAuth, 1)
    const IS_PANEL = bus.authHas(sessAuth, [3])

    if (TO_HAS_SESS) {
      document.title = title
      next()
    } else {
      next(false)
      if (SESS_EXISTS) {
        if (IS_ADMIN) {
          router.push('/manage/users')
        } else if (IS_PANEL) {
          router.push('/dashboard')
        }
      } else {
        router.push('/')
      }
    }

    bus.refresh(false)
  }

  bus.$on('watch--session.auth', (route) => {
    beforeEach(route, null, (e) => {})
  })

  router.beforeEach((to, from, next) => {
    // check for session
    bus.sessionCheck(to, http)
    beforeEach(to, from, next)
  })
}
