// Create an instance of Notyf
const notyf = new Notyf();

// Flatpickr
flatpickr("#selectMonth", {
  maxDate: "today",
  dateFormat: "Y-m",
  mode: "single",
});

$(document).ready(function() {
  getTicketCount();
})


// Get Ticket Data
function getTicketCount () {
  $.ajax({
      type: "GET",
      url: `/backend/admin/getTicketCount`,
      headers: {
          'X-CSRF-TOKEN': csrfToken  // Add CSRF token to the request headers
      },
      success: function(response){
        var chartDom = document.getElementById('analytic-chart');
        var myChart = echarts.init(chartDom);
        var option;
        
        option = {
          title: {
            text: 'Ticket Analytics',
            subtext: `${response.office_Name}`,
            left: 'center'
          },
          tooltip: {
            trigger: 'item'
          },
          legend: {
            orient: 'horizontal',
            bottom: 'bottom'
          },
          series: [
            {
              name: 'Access From',
              type: 'pie',
              radius: '50%',
              data: [
                { value: `${response.pending_count}`, name: 'Pending' },
                { value: `${response.in_progress_count}`, name: 'In Progress' },
                { value: `${response.resolved_count}`, name: 'Resolved' },
                { value: `${response.closed_count}`, name: 'Closed' }
              ],
              emphasis: {
                itemStyle: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
              }
            }
          ]
        };
        
        option && myChart.setOption(option);
      },
      error: function() {
          notyf.error({
              position: {x: 'right', y: 'top'},
              duration: 2000,
              ripple: true,
              message: "There was an error while retrieving ticket counts.",
          });
      }
  });
}
