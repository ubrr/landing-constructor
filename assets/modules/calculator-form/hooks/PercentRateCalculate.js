export const calculatePercentRate = (
    creditTitle,
    creditSum,
    extraMoneySum,
    financeProtection,
    ubrrCardAccount
) => {
  let percentRate;
  if (creditTitle === "Refenans") {
    if (creditSum + extraMoneySum < 700000) {
      if (ubrrCardAccount) {
        percentRate = financeProtection ? 7 : 12;
      } else {
        percentRate = financeProtection ? 9 : 14;
      }
    } else {
      if (ubrrCardAccount) {
        percentRate = financeProtection ? 6.5 : 11.5;
      } else {
        percentRate = financeProtection ? 8.5 : 13.5;
      }
    }
  }
  if (creditTitle === "AnyPurpose") {
    if (financeProtection && !ubrrCardAccount) {
      if (creditSum >= 50000 && creditSum <= 299999) {
        percentRate = 12;
      } else if (creditSum >= 300000 && creditSum <= 749999) {
        percentRate = 11.5;
      } else if (creditSum >= 750000 && creditSum <= 1499999) {
        percentRate = 8;
      } else {
        percentRate = 6.3;
      }
    } else if (!financeProtection && !ubrrCardAccount) {
      if (creditSum >= 50000 && creditSum <= 299999) {
        percentRate = 17;
      } else if (creditSum >= 300000 && creditSum <= 749999) {
        percentRate = 16.5;
      } else if (creditSum >= 750000 && creditSum <= 1499999) {
        percentRate = 13;
      } else {
        percentRate = 11.3;
      }
    } else if (financeProtection && ubrrCardAccount) {
      if (creditSum >= 50000 && creditSum <= 299999) {
        percentRate = 11.3;
      } else if (creditSum >= 300000 && creditSum <= 749999) {
        percentRate = 11;
      } else if (creditSum >= 750000 && creditSum <= 1499999) {
        percentRate = 7.5;
      } else {
        percentRate = 6.3;
      }
    } else if (!financeProtection && ubrrCardAccount) {
      if (creditSum >= 50000 && creditSum <= 299999) {
        percentRate = 16.3;
      } else if (creditSum >= 300000 && creditSum <= 749999) {
        percentRate = 16;
      } else if (creditSum >= 750000 && creditSum <= 1499999) {
        percentRate = 12.5;
      } else {
        percentRate = 11.3;
      }
    }
  }
  if (creditTitle === "WithoutDoc") {
    if (financeProtection) percentRate = 12;
    else percentRate = 17;
  }
  return percentRate;
};
