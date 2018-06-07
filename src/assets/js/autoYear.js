const year = 2018
const now = (new Date()).getFullYear()

export default year === now ? year : year + '-' + now
