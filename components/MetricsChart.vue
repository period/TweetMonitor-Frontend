<template>
    <line-chart
        v-if="data != null && data.datasets.length > 0"
        :data="data"
        :options="{
                responsive: true,
                spanGaps: true, 
                maintainAspectRatio: false, 
                scales: {
                    xAxes: [
                        {type:'time'}
                    ]
                }
            }"
    />
</template>
<script>
export default {
    name: "MetricsChart",
    props: {
        metrics: {
        },
        display: {

        }
    },
    data() {
        return {
            data: {
                labels: this.metrics.map((el) => { return new Date(parseInt(el.timestamp)) }),
                datasets: []
            }
        }
    },
    mounted() {
        let colour_map = {
            "Impressions": "#1DA1F2",
            "Retweets": "#19cf86",
            "Quotes": "#14171A",
            "Likes": "#e3396d",
            "Profile Clicks": "#AAB8C2",
            "Replies": "#657786"
        }
        for(let prop of this.display) {
            this.data.datasets.push({
                label: prop,
                data: this.metrics.map((el) => { return el[prop.toLowerCase().replace(" ", "_")] }),
                borderColor: colour_map[prop],
                backgroundColor: 'rgba(0,0,0,0)'
            })
        }
    }
}
</script>