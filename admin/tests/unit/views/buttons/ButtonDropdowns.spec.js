import Vue from 'vue'
import { shallowMount, mount } from '@vue/test-utils'
import CoreuiVue from '@coreui/vue'
import Dropdowns from '@/views/buttons/Dropdowns'

Vue.use(CoreuiVue)

describe('Dropdowns.vue', () => {
  it('has a name', () => {
    expect(Dropdowns.name).toBe('Dropdowns')
  })
  it('is Vue instance', () => {
    const wrapper = shallowMount(Dropdowns)
    expect(wrapper.isVueInstance()).toBe(true)
  })
  it('is Dropdowns', () => {
    const wrapper = shallowMount(Dropdowns)
    expect(wrapper.is(Dropdowns)).toBe(true)
  })
  test('renders correctly', () => {
    const wrapper = mount(Dropdowns)
    expect(wrapper.element).toMatchSnapshot()
  })
})
