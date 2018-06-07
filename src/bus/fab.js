export default {
  model: false,
  inst: {
    ManageUsers: {
      color: 'accent',
      before: 'add',
      after: 'close',
      click: 'user--add',
      tip: 'Create user',
      btns: null
    },
    ManageProjects: {
      color: 'accent',
      before: 'add',
      after: 'close',
      click: 'project--add',
      tip: 'Create project',
      btns: null
    },
    ManageCategories: {
      color: 'accent',
      before: 'add',
      after: 'close',
      click: 'category--add',
      tip: 'Create category',
      btns: null
    }
  }
}
