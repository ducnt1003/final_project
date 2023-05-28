import Vuex from 'vuex'
import dialog from './dialog'
import sidebar from './sidebar'
import dynamicBreadcrumb from './dynamicBreadcrumb'
import * as Auth from '../store/modules/auth.js'
import * as User from '../store/modules/user.js'

export default new Vuex.Store({
    modules: {
      sidebar,
      dialog,
      dynamicBreadcrumb,
      Auth,
      User,
    }
})
