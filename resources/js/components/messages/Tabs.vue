<template>
    <div>
        <ul class="nav nav-tabs">
            <li v-for="(tab, index) in tabs" :ref="tab.name" class="nav-item" :key="index">
                <a class="nav-link" :class="{ 'active': tab.isActive }" 
                @click="selectTab(tab)">{{ tab.name }}</a>
            </li>
        </ul>
        <div class="tab-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return { 
            tabs: [] 
        }
    },

    created() {
        this.tabs = this.$children;

        events.$on('replyToMessage', (nickname) => {
            this.navigateToTab('#send-message');
        });
    },

    methods: {
        selectTab(selectedTab) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.href == selectedTab.href);
            });
        },

        navigateToTab(href) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.href == href);
            });
        }
    }
}
</script>
