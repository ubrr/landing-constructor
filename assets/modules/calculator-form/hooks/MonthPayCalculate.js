export const calculateMonthPay = (summ, extraMoneySum, percentStavka, years, creditTitle) => {
  years = parseInt(years);
  let k =
    ((percentStavka / 1200) *
      Math.pow(1 + percentStavka / 1200, years * 12.0)) /
    (Math.pow(1 + percentStavka / 1200, years * 12.0) - 1);
  let payment;

  if (creditTitle === "Refenans") {
    payment = (summ + extraMoneySum) * k;
  } else {
    payment = summ * k;
  }

  return payment;
};
