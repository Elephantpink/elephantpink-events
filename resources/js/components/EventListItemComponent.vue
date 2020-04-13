<template>
  <div class="event">
    <div class="row">
      <div class="title">
        {{ event.name }}
        <div class="responsive">{{ event.location }} - {{ date }}</div>
      </div>
      <div class="location">{{ event.location }}</div>
      <div class="date">{{ date }}</div>
      <div class="options">
        <button type="button" @click="showMenu = true">
          <svg-vue icon="menu" />
        </button>
        <transition name="fade">
          <div class="menu" v-show="showMenu">
            <button type="button" @click="editEvent()">
              <span>{{ $root.trans('events_admin.edit') }}</span>
              <svg-vue icon="edit" />
            </button>
            <button type="button" @click="deleteEvent()">
              <span>{{ $root.trans('events_admin.delete') }}</span>
              <svg-vue icon="close" />
            </button>
          </div>
        </transition>
      </div>
    </div>
    <div class="transparent-overlay" v-show="showMenu" @click="showMenu = false" />
  </div>
</template>

<script>
export default {
  props: {
    event: { type: Object, default: null }
  },
  data() {
    return {
      showMenu: false
    };
  },
  computed: {
    date: function() {
      let eventDate = new Date(this.event.date);
      let final = "";

      if (eventDate) {
        let date =
          (eventDate.getDate() < 10
            ? "0" + eventDate.getDate()
            : eventDate.getDate()) +
          "." +
          (eventDate.getMonth() < 9
            ? "0" + (eventDate.getMonth() + 1)
            : eventDate.getMonth() + 1) +
          "." +
          eventDate
            .getFullYear()
            .toString()
            .substr(-2, 2);
        let time =
          (eventDate.getHours() < 10
            ? "0" + eventDate.getHours()
            : eventDate.getHours()) +
          ":" +
          (eventDate.getMinutes() < 10
            ? "0" + eventDate.getMinutes()
            : eventDate.getMinutes());

        final = date + " @ " + time;
      }

      return final;
    }
  },
  methods: {
    deleteEvent() {
      this.showMenu = false;
      this.$emit("delete-event", this.event);
    },
    editEvent() {
      this.showMenu = false;
      this.$emit("edit-event", this.event);
    }
  }
};
</script>

<style lang="scss">
.event {
  .row {
    .title {
      .responsive {
        display: none;
      }
    }
  }
}

@media only screen and (max-width: 990px) {
  .event {
    .row {
      .title {
        flex-direction: column;
        justify-content: flex-start;
        width: 100%;
        .responsive {
          display: block;
          width: 100%;
          margin-top: 10px;
          font-family: rubiklight;
          font-size: 12px;
        }
      }
    }
  }
}
</style>