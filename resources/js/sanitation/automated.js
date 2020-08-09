new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           sanitationIterator: 10, // nextIndex = array[index + 10]
           automatedLabel : '',
           sanitationBtn: false,
           processRowStartArr: [],
           rowCount: 0,
           rowCountField: false,
           totalSanitizedRow: 0,
           percentageSanitizedRow: 0,
           totalUnsanitizedRow: 0,
           totalSanitizedAmount: 0,
           totalRaw: 0,
           rowsPerSanitationProcess: 50,
           currentSanitationProcess: 0,
           totalSanitationProcess:  0,
           percentageSanitationProcess: 0
        }
    },
    filters: {
        numberFormat: function(num)
        {
            if(num)
            {
                return num.toLocaleString();
            }else
            {
                return num;
            }
        },
        decimalFormat: function(num)
        {
            if(num || !isNaN(num))
            {
                return num.toFixed(2);
            }else
            {
                return num;
            }
        }
    },
    methods : {
        startConsole: function()
        {
            this.automatedLabel = 'Sanitation in process...';

            let sanitationProcessNeeded = (this.rowCount / this.rowsPerSanitationProcess);
            let processRowStart = 0;

            for(let i = 0; i < sanitationProcessNeeded; i++)
            {
                if(i === 0)
                {
                    processRowStart = 0;
                }else
                {
                    processRowStart = (i * this.rowsPerSanitationProcess) + 1;
                }

                this.processRowStartArr.push(processRowStart);
            }

            this.totalSanitationProcess = sanitationProcessNeeded;

            this.sanitationProcess1(0);
            this.sanitationProcess1(1);
            this.sanitationProcess1(2);
            this.sanitationProcess1(3);
            this.sanitationProcess1(4);
            this.sanitationProcess1(5);
            this.sanitationProcess1(6);
            this.sanitationProcess1(7);
            this.sanitationProcess1(8);
            this.sanitationProcess1(9);
        },
        sanitationProcess1: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess1(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess2: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess2(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess3: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess3(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess4: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess4(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess5: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess5(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess6: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess6(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess7: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess7(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess8: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess8(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess9: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess9(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess10: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess10(nextIndex);
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.automatedLabel = '';
                    this.sanitationBtn = false;
                    this.rowCountField = false;
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        }
    }

});