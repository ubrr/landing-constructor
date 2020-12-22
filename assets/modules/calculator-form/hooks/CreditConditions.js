import { useState } from "react";
import { calculateMonthPay } from "./MonthPayCalculate";
import { useParams } from "./Constants";
import { calculatePercentRate } from "./PercentRateCalculate";

export const useCreditConditions = (creditTitle) => {
  const { getCreditParameters } = useParams();
  const creditParameters = getCreditParameters(creditTitle);

  let document = [
    "Паспорт",
    "Справка о доходах или выписка из ПФР",
  ]

  if (creditTitle==="WithoutDoc" || creditTitle==="Refenans") document = ["Паспорт"]

  const [creditCondition, setCreditCondition] = useState({
    creditSum: creditParameters["defaultCreditSum"],
    extraMoneySum: creditParameters["defaultExtraMoneySum"],
    term: creditParameters["termList"][0],
    percentRate: creditParameters["percentRate"],
    monthPay: calculateMonthPay(
        creditParameters["defaultCreditSum"],
        creditParameters["defaultExtraMoneySum"],
        creditParameters["percentRate"],
        creditParameters["termList"][0],
        creditTitle
    ),
    financeProtection: true,
    ubrrCardAccount: false,
    extraMoneyCheckBox: false,
    documents: document
  });

  const changeCreditCondition = (
      creditSum,
      extraMoneySum,
      term,
      financeProtection,
      ubrrCardAccount,
      extraMoneyCheckBox
  ) => {
    if (creditSum + extraMoneySum > creditParameters['maxAmount']) {
      extraMoneySum = creditParameters['maxAmount'] - creditSum;
    }

    if (creditSum >= creditParameters['minAmount'] && creditSum <= creditParameters['maxAmount']) {
      if (creditSum + extraMoneySum < 300000 && term === "10") {
        term = "7";
      }

      if (creditTitle === "Refenans") {
        if (extraMoneyCheckBox && !ubrrCardAccount) {
          document = ["Паспорт", "Справка о доходах или СНИЛС"];
        } else {
          document = ["Паспорт"];
        }
      } else {
        if (ubrrCardAccount || creditSum + extraMoneySum < 300000) {
          document = ["Паспорт"];
        } else if (creditSum + extraMoneySum < 1500000 && !ubrrCardAccount) {
          document = ["Паспорт", "Справка о доходах или выписка из ПФР"];
        } else {
          document = ["Паспорт", "Выписка из ПФР"];
        }
      }

      const percent = calculatePercentRate(
          creditTitle,
          creditSum,
          extraMoneySum,
          financeProtection,
          ubrrCardAccount
      );

      const monthPayment = calculateMonthPay(creditSum, extraMoneySum, percent, term, creditTitle);

      setCreditCondition({
        creditSum: creditSum,
        extraMoneySum: extraMoneySum,
        term: term,
        percentRate: percent,
        monthPay: monthPayment,
        financeProtection: financeProtection,
        ubrrCardAccount: ubrrCardAccount,
        extraMoneyCheckBox: extraMoneyCheckBox,
        documents: document,
      });
    } else {
      setCreditCondition({
        ...creditCondition,
        creditSum: creditSum,
      });
    }
  };

  return {
    changeCreditCondition,
    creditCondition,
  };
};

