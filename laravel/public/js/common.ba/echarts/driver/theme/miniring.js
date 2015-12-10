define(function (requrie, a, b) {
    b.exports = {
        backgroundColor:"#ffffff",
        color: ["#ddd","red"],
        title:{
          show:false
        },
        pie:{
            itemStyle:{
                normal : {
                    label : {
                        position : 'center',
                        formatter : '{d}  %',
                        textStyle:{
                            color:"#444"
                        }

                    },
                    labelLine : {
                        show : false
                    }

                }

            }
        }

    }
});