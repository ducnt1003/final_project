/********************************************
 *** File Name: i18n.js                   ***
 *** Description: i18n configure          ***
 *** Creator: Cowell: Linh Huy Do      ***
 *** Created at: 2021/10/28               ***
 ********************************************/

import { createApp } from 'vue'
import { createI18n } from 'vue-i18n'
import i18nData from './i18nData'



export default new createI18n({
  locale: 'vi',
  fallbackLocale: 'vi',
  messages: i18nData,
})
