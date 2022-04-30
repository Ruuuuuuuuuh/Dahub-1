<template>
    <div class="transactionCell">
        <div class="transactionCell__top">
            <div class="transactionCell__number">#{{number}}</div>
            <div class="transactionCell__type">{{type}}</div>
        </div>
        <div class="transactionCell__bottom">
            <div class="transactionCell__sum" :class="sumClassName">
                <div class="transactionCell__icon">
                    <span v-if="destination == 'deposit'">+</span>
                    <span v-if="destination == 'withdraw'" > – </span>
                    <span v-if="destination == 'transfer'" > – </span>
                </div>

                <span>{{sum}} {{currency}}</span>
            </div>
            <div class="transactionCell__date">{{date}}</div>
        </div>
    </div>
</template>

<script>
export default {

    props: ['number', 'type','sum', 'currency', 'date', 'destination'],
    computed: {
        sumClassName: function() {
            let className = 'transactionCell__sum_gray'
            if(this.destination == 'deposit') {
                className = 'transactionCell__sum_gradient'
            }
            if(this.destination == 'withdraw') {
                className = 'transactionCell__sum_red'
            }
            if(this.destination == 'transfer') {
                className = 'transactionCell__sum_red'
            }
            return className

        }
    }
};
</script>

<style scoped>
.transactionCell {
    display: flex;
    flex-direction: column;
    padding: 10px 0px 12px;
    position: relative;
}
.transactionCell::after {
    content: "";
    position: absolute;
    bottom: 0;
    height: 1px;
    width: 130%;
    background: #E6EBF8;
}
.transactionCell:last-of-type {
    margin-bottom: 100px;
}
.transactionCell__top,
.transactionCell__bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.transactionCell__top {
    margin-bottom: 4px;
}
.transactionCell__number,
.transactionCell__type {
    font-weight: 300;
    font-size: 12px;
    line-height: 24px;
    color: #485068;
}
.transactionCell__sum {
    font-weight: 700;
    font-size: 16px;
    line-height: 28px;
    display: flex;
    align-items: center;
}
.transactionCell__date {
    font-weight: 600;
    font-size: 12px;
    line-height: 24px;
    color:#485068;
}
.transactionCell__sum_gradient span {
    background:linear-gradient(85.24deg, #85F362 -116.44%, #02AAFF 68.46%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.transactionCell__sum_gray {
    color: #78829C;
    opacity: .9;
}

.transactionCell__sum_red {
    background:linear-gradient(90.79deg, #FFAE34 0.52%, #FF3998 94.29%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    opacity: 0.9;
}
.transactionCell__icon {
    margin-right: 4px;
}

</style>
