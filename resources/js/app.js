import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.estateFlowChatbot = (endpoint) => ({
    open: false,
    draft: '',
    loading: false,
    messages: [
        {
            id: 1,
            role: 'assistant',
            text: 'Hi, I can help you find homes, understand EstateFlow, and open the right property detail pages.',
            suggestions: ['Show featured homes', 'Find homes for sale', 'Find rentals'],
            properties: [],
        },
    ],

    async send(text = null) {
        const message = (text || this.draft).trim();

        if (!message || this.loading) {
            return;
        }

        this.messages.push({
            id: Date.now(),
            role: 'user',
            text: message,
        });

        this.draft = '';
        this.loading = true;
        this.scrollToBottom();

        try {
            const history = this.messages
                .filter((item) => item.text)
                .slice(-10)
                .map((item) => ({
                    role: item.role,
                    text: item.text,
                }));

            const response = await window.axios.post(endpoint, { message, history });

            this.messages.push({
                id: Date.now() + 1,
                role: 'assistant',
                text: response.data.reply,
                properties: response.data.properties || [],
                suggestions: response.data.suggestions || [],
            });
        } catch (error) {
            this.messages.push({
                id: Date.now() + 1,
                role: 'assistant',
                text: 'Assistant is not available at this time. Please try again soon.',
                properties: [],
                suggestions: ['Show featured homes', 'Find rentals'],
            });
        } finally {
            this.loading = false;
            this.scrollToBottom();
        }
    },

    scrollToBottom() {
        this.$nextTick(() => {
            if (this.$refs.messages) {
                this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
            }
        });
    },
});

Alpine.start();
