import Vue from 'vue'
import { shallowMount } from '@vue/test-utils'
import CoreuiVue from '@coreui/vue'
import Navs from '@/views/base/Navs'

Vue.use(CoreuiVue)

describe('Navs.vue', () => {
  it('has a name', () => {
    expect(Navs.name).toBe('Navs')
  })
  it('is Vue instance', () => {
    const wrapper = shallowMount(Navs)
    expect(wrapper.isVueInstance()).toBe(true)
  })
  it('is Navbars', () => {
    const wrapper = shallowMount(Navs)
    expect(wrapper.is(Navs)).toBe(true)
  })
  test('renders correctly', () => {
    const wrapper = shallowMount(Navs)
    expect(wrapper.element).toMatchSnapshot()
  })
})
