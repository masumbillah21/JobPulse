export const chartColors = {
  default: {
    primary: '#00D1B2',
    info: '#209CEE',
    danger: '#FF3860'
  }
}
const datasetObject = (color, points) => {
  return {
    fill: false,
    borderColor: chartColors.default[color],
    borderWidth: 2,
    borderDash: [],
    borderDashOffset: 0.0,
    pointBackgroundColor: chartColors.default[color],
    pointBorderColor: 'rgba(255,255,255,0)',
    pointHoverBackgroundColor: chartColors.default[color],
    pointBorderWidth: 20,
    pointHoverRadius: 4,
    pointHoverBorderWidth: 15,
    pointRadius: 4,
    data: [],
    tension: 0.5,
    cubicInterpolationMode: 'default'
  }
}

export const chartTemplate = (points = 12) => {
  const labels = []

  for (let i = 1; i <= points; i++) {
    if (i < 10) {
      labels.push(`0${i}`)
    }else{
      labels.push(i)
    }
  }

  return {
    labels,
    datasets: [
      datasetObject('primary', points),
      datasetObject('info', points),
      datasetObject('success', points)
    ]
  }
}
