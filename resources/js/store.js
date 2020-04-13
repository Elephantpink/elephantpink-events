import Vue from 'vue'
import axios from 'axios'

let eventsStore = {
    state: {
        eventsAPI: '/api/v1/events',
        events: [],
    },
    getters: {
        eventsAPI: state => {
            return state.eventsAPI
        },
        events: state => {
            return state.events
        },
    },
    mutations: {
        setEvents(state, events) {
            state.events = events
        },
        addEvent(state, event) {
            state.events.push(event)
        },
        updateEvent(state, updatedEvent) {
            let event = state.events.filter(e => { return e.id == updatedEvent.id })

            if (event.length) {
                Vue.set(state.events, state.events.indexOf(event[0]), updatedEvent)
            }
        },
        deleteEvent(state, event) {
            state.events.splice(state.events.indexOf(event), 1)
        }
    },
    actions: {
        getEvents({ commit, getters }) {
            return axios.get(getters.eventsAPI)
                .then(response => {
                    commit('setEvents', response.data.events)
                })
                .catch(error => {
                    console.error(error)
                })
        },
        createEvent({ commit, getters }, event) {
            return new Promise((resolve, reject) => {
                axios.post(getters.apiURL + 'events', event)
                    .then(response => {
                        commit('addEvent', response.data.event)
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        editEvent({ commit, getters }, event) {
            return new Promise((resolve, reject) => {
                axios.put(getters.apiURL + 'events/' + event.id, event)
                    .then(response => {
                        commit('updateEvent', event)
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        deleteEvent({ commit, getters }, event) {
            return new Promise((resolve, reject) => {
                axios.delete(getters.apiURL + 'events/' + event.id)
                    .then(response => {
                        commit('deleteEvent', event)
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        }
    }
}

export default eventsStore