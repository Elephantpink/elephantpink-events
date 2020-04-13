<template>
  <div class="events-page">
    <nav class="topbar-container">
      <div class="right-container">
        <button type="button" @click="showEventFormModal = true">
          <svg-vue icon="plus-round" />
          {{ $root.trans('events_admin.create_new') }}
        </button>
      </div>
    </nav>

    <div class="view-wrapper">
      <div class="view-container">
        <div class="table-container">
          <orderable-headers-component
            :config="eventsTableConfig"
            :extraHeader="true"
            @update-order-by="updateOrderBy($event)"
          />
          <div class="events-list">
            <div v-for="event in eventsList" :key="'event-' + event.id">
              <event-list-item-component
                :event="event"
                @edit-event="editEvent($event)"
                @delete-event="confirmDelete($event)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <transition name="fade">
      <div class="overlay" v-show="showDeleteEvent" @click="showDeleteEvent = false">
        <div @click.stop.prevent>
          <span class="overlay-title">
            <svg-vue icon="risk" class="icon" />
            {{ eventToDeleteTitle }}
          </span>
          <div class="overlay-content">
            <span>{{ $root.trans('events_admin.delete_confirm')}}</span>
            {{ $root.trans('events_admin.not_undone') }}
          </div>
          <div class="buttons-container">
            <button type="button" class="btn-cancel" @click="closeDeleteModal()">
              {{ $root.trans('events_admin.cancel') }}
            </button>
            <button type="button" class="cta" @click="deleteEvent()">
              {{ $root.trans('events_admin.delete') }}
            </button>
          </div>
        </div>
      </div>
    </transition>

    <transition name="fade">
      <div v-show="showEventFormModal" class="overlay" @click="closeEventFormModal()">
        <div class="form-wrapper" @click.stop>
          <button type="button" class="btn-close" @click="closeEventFormModal()">
            {{ $root.trans('events_admin.close') }} X
          </button>
          <form @submit.prevent="submitEventForm()">
            <div class="form-container">
              <div class="fields-wrapper">
                <div class="field-container">
                  <label for="name">
                    {{ $root.trans('events_admin.name') }}
                  </label>
                  <input type="text" name="name" v-model="eventForm.name" required />
                </div>
                <div class="field-container">
                  <label for="name">
                    {{ $root.trans('events_admin.location') }}
                  </label>
                  <input type="text" name="location" v-model="eventForm.location" required />
                </div>
                <div class="field-container">
                  <label for="description">
                    {{ $root.trans('events_admin.description') }}
                  </label>
                  <textarea
                    name="description"
                    v-model="eventForm.description"
                    rows="6"
                    maxlength="720"
                  />
                </div>
              </div>
              <div class="field-container date-container">
                <div class="date">
                  <label for="date">
                    {{ $root.trans('events_admin.date') }}
                  </label>
                  <div>
                    <input
                      type="date"
                      ref="program_date"
                      name="program_date"
                      v-model="eventForm.new_date.date"
                      :required="!eventForm.id"
                    />
                  </div>
                </div>
                <div class="time">
                  <label for="time">
                    {{ $root.trans('events_admin.hour') }}
                  </label>
                  <div>
                    <input
                      type="number"
                      ref="program_hours"
                      name="program_hours"
                      min="0"
                      max="23"
                      v-model="eventForm.new_date.hours"
                      @change="updateHours($event)"
                      placeholder="00"
                      :required="!eventForm.id"
                    />
                    <input
                      type="number"
                      ref="program_minutes"
                      name="program_minutes"
                      min="0"
                      max="59"
                      v-model="eventForm.new_date.minutes"
                      @change="updateMinutes($event)"
                      placeholder="00"
                      :required="!eventForm.id"
                    />
                  </div>
                </div>
              </div>
              <div class="last-modified" v-if="eventForm.id">
                {{ $root.trans('events_admin.event_date') }}:
                <span>{{ eventDate }}</span>
              </div>
            </div>
            <div class="buttons-container">
              <button type="submit" class="cta full">{{ eventModalCTAText }}</button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
// Do your imports here
import { mapGetters } from "vuex";
import EventListItemComponent from "../components/EventListItemComponent";
import OrderableHeadersComponent from "../components/OrderableHeadersComponent";

export default {
  components: {
    EventListItemComponent,
    OrderableHeadersComponent
  },
  data() {
    return {
      errors: null,
      eventsTableConfig: {
        headers: ["events_admin.name", "events_admin.location", "events_admin.date"],
        fields: ["name", "location", "date"],
        filterBy: "",
        orderBy: [-3]
      },
      eventToDelete: null,
      showDeleteEvent: false,
      showEventFormModal: false,
      eventForm: {
        name: "",
        description: "",
        location: "",
        new_date: {
          date: null,
          hours: null,
          minutes: null
        }
      }
    };
  },
  computed: {
    ...mapGetters(["events"]),
    eventDate: function() {
      let event_date = new Date(this.eventForm.date);
      let final = "";

      if (event_date.getTime() === event_date.getTime()) {
        let date =
          (event_date.getDate() < 10
            ? "0" + event_date.getDate()
            : event_date.getDate()) +
          "." +
          (event_date.getMonth() < 9
            ? "0" + (event_date.getMonth() + 1)
            : event_date.getMonth() + 1) +
          "." +
          event_date
            .getFullYear()
            .toString()
            .substr(-2, 2);
        let time =
          (event_date.getHours() < 10
            ? "0" + event_date.getHours()
            : event_date.getHours()) +
          ":" +
          (event_date.getMinutes() < 10
            ? "0" + event_date.getMinutes()
            : event_date.getMinutes());

        final = date + " @ " + time;
      }

      return final;
    },
    eventsList: function() {
      return this.$root.prepareTable(
        Object.values(this.events),
        this.eventsTableConfig.fields,
        this.eventsTableConfig.orderBy,
        { title: this.eventsTableConfig.filterBy }
      );
    },
    eventModalCTAText: function() {
      const text = this.eventForm.id ? "save_changes" : "create";
      return this.$root.trans('events_admin.' + text)
    },
    eventToDeleteTitle: function() {
      return this.eventToDelete ? this.eventToDelete.name : "";
    }
  },
  methods: {
    closeDeleteModal() {
      this.showDeleteEvent = false;
      this.eventToDelete = null;
    },
    closeEventFormModal() {
      this.showEventFormModal = false;
      this.eventForm = {
        name: "",
        description: "",
        location: "",
        new_date: {
          date: null,
          hours: null,
          minutes: null
        }
      };
    },
    confirmDelete(event) {
      this.showDeleteEvent = true;
      this.eventToDelete = event;
    },
    deleteEvent() {
      this.$store.dispatch("deleteEvent", this.eventToDelete).then(() => {
        this.showDeleteEvent = false;
      });
    },
    editEvent(event) {
      this.eventForm = Object.assign({}, event);
      this.eventForm.new_date = {
        date: null,
        hours: null,
        minutes: null
      };
      this.showEventFormModal = true;
    },
    submitEventForm() {
      if (this.eventForm.id) {
        let event = Object.assign({}, this.eventForm);
        if (this.eventForm.new_date.date) {
          if (this.eventForm.new_date.hours) {
            event.date =
              this.eventForm.new_date.date +
              " " +
              this.eventForm.new_date.hours +
              ":" +
              this.eventForm.new_date.minutes +
              ":00";
          } else {
            let originalDate = new Date(event.date);
            event.date =
              this.eventForm.new_date.date +
              " " +
              originalDate.getHours() +
              ":" +
              originalDate.getMinutes() +
              ":00";
          }
        } else {
          let originalDate = new Date(event.date);
          let originalYear = originalDate.getFullYear();
          let originalMonth =
            originalDate.getMonth() < 10
              ? "0" + (originalDate.getMonth() + 1)
              : originalDate.getMonth() + 1;
          let originalDay =
            originalDate.getDate() < 10
              ? "0" + (originalDate.getDate() + 1)
              : originalDate.getDate();
          if (this.eventForm.new_date.hours) {
            event.date =
              originalYear +
              "-" +
              originalMonth +
              "-" +
              originalDay +
              " " +
              this.eventForm.new_date.hours +
              ":" +
              this.eventForm.new_date.minutes +
              ":00";
          }
        }
        delete event.new_date;
        this.$store.dispatch("editEvent", event).then(() => {
          this.closeEventFormModal();
        });
      } else {
        this.eventForm.date =
          this.eventForm.new_date.date +
          " " +
          this.eventForm.new_date.hours +
          ":" +
          this.eventForm.new_date.minutes +
          ":00";
        this.$store.dispatch("createEvent", this.eventForm).then(() => {
          this.closeEventFormModal();
        });
      }
    },
    updateOrderBy(field) {
      if (Math.abs(this.eventsTableConfig.orderBy[0]) === field) {
        Vue.set(
          this.eventsTableConfig.orderBy,
          0,
          this.eventsTableConfig.orderBy[0] * -1
        );
      } else {
        Vue.set(this.eventsTableConfig.orderBy, 0, field);
      }
    },
    updateHours(event) {
      this.eventForm.new_date.hours =
        event.target.value < 10 && event.target.value.length < 2 ? "0" + event.target.value : event.target.value;
    },
    updateMinutes(event) {
      this.eventForm.new_date.minutes =
        event.target.value < 10 && event.target.value.length < 2 ? "0" + event.target.value : event.target.value;
    }
  }
};
</script>

<style lang="scss">
.events-page .topbar-container {
  justify-items: flex-end;
  justify-content: flex-end;
}

.date-container {
  flex-direction: row;

  > div {
    &:first-child {
      margin-right: 15px;
    }

    label {
      display: flex;
    }
  }
}

textarea {
  resize: none;
  outline: none;
  background-color: #f6f6f6;
  padding: 25px;
  border: 0;
  font-family: "rubiklight";
  font-size: 13px;
  line-height: 23px;
}

@media only screen and (max-width: 990px) {
  .date-container {
    flex-direction: column;

    > div:first-child {
      margin: 0;
    }
    
    .date,
    .time {
      display: block;
    }

    .date {
      input {
        width: 100%;
      }
    }

    .time {
      div {
        display: flex;
        justify-content: space-between;
      }
      
      input {
        width: calc(50% - 10px);
        box-sizing: border-box;
      }
    }
  }
}
</style>