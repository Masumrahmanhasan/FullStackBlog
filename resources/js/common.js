export default {
    data(){
        return {

        }
    },
    methods: {
        async callApi(method, url, dataObj){
                try {
                    return await axios({
                        method:method,
                        url:url,
                        data: dataObj
                    });
                } catch (error) {
                    return error.response
                }
            },
            info (desc, title="Hey!") {
                this.$Notice.info({
                    title: title,
                    desc: desc
                });
            },
            success (desc, title="Success") {
                this.$Notice.success({
                    title: title,
                    desc: desc
                });
            },
            warning (desc, title="Warning") {
                this.$Notice.warning({
                    title: title,
                    desc: desc
                });
            },
            error (desc, title="Oops!") {
                this.$Notice.error({
                    title: title,
                    desc: desc
                });
            },
            swr(desc='Somethingn went wrong! Please try again.', title="Oops") {
                this.$Notice.error({
                    title: title,
                    desc: desc
                });
            },
        }

    }
