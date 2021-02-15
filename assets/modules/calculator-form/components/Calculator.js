import React from "react";
import { CheckBox } from "./CheckBox";
import { Slider } from "./Slider";
import { ExtraMoneyBox } from "./ExtraMoneyBox";
import { Tooltip } from "./Tooltip";
import { ListTerms } from "./ListTerms";
import { MonthPay } from "./MonthPay";
import { useParams } from "../hooks/Constants";
import { useCreditConditions } from "../hooks/CreditConditions";
import '../styles/style.scss'

export const Calculator = (props) => {
  const creditTitle = props.creditTitle;
  const { getCreditParameters } = useParams();
  const creditParameters = getCreditParameters(creditTitle);
  const { creditCondition, changeCreditCondition } = useCreditConditions(
      creditTitle
  );

  const setCheckedOnFinanceProtection = () => {
    changeCreditCondition(
        creditCondition["creditSum"],
        creditCondition["extraMoneySum"],
        creditCondition["term"],
        !creditCondition["financeProtection"],
        creditCondition["ubrrCardAccount"],
        creditCondition["extraMoneyCheckBox"]
    );
  };
  const setCheckedOnExtraMoney = () => {
    let extraMoney = creditCondition["extraMoneySum"];

    if (creditCondition["extraMoneyCheckBox"]) {
      extraMoney = 0;
    }
    changeCreditCondition(
        creditCondition["creditSum"],
        extraMoney,
        creditCondition["term"],
        creditCondition["financeProtection"],
        creditCondition["ubrrCardAccount"],
        !creditCondition["extraMoneyCheckBox"]
    );
  };
  const changeUbrrAccount = () => {
    changeCreditCondition(
        creditCondition["creditSum"],
        creditCondition["extraMoneySum"],
        creditCondition["term"],
        creditCondition["financeProtection"],
        !creditCondition["ubrrCardAccount"],
        creditCondition["extraMoneyCheckBox"]
    );

  };
  const changeCreditSum = (credit) => {
    changeCreditCondition(
        credit,
        creditCondition["extraMoneySum"],
        creditCondition["term"],
        creditCondition["financeProtection"],
        creditCondition["ubrrCardAccount"],
        creditCondition["extraMoneyCheckBox"]
    );
  };
  const changeExtraMoneySum = (extraMoney) => {
    changeCreditCondition(
        creditCondition["creditSum"],
        extraMoney,
        creditCondition["term"],
        creditCondition["financeProtection"],
        creditCondition["ubrrCardAccount"],
        creditCondition["extraMoneyCheckBox"]
    );
  };
  const changeTerm = (srok) => {
    changeCreditCondition(
        creditCondition["creditSum"],
        creditCondition["extraMoneySum"],
        srok,
        creditCondition["financeProtection"],
        creditCondition["ubrrCardAccount"],
        creditCondition["extraMoneyCheckBox"]
    );
  };
  const mounthPayCalculate = (srok) => {
    changeCreditCondition(
        creditCondition["creditSum"],
        creditCondition["extraMoneySum"],
        srok,
        creditCondition["financeProtection"],
        creditCondition["ubrrCardAccount"],
        creditCondition["extraMoneyCheckBox"]
    );
  };

  return (
      <div className="calculatorForm">
        <div className="wrapper">
          <div className="title">Рассчитайте свой кредит</div>
          <div className="mainBox">
            <div className="whiteBox">
              <CheckBox checked={creditCondition["financeProtection"]} checkChange={setCheckedOnFinanceProtection}>
                Финансовая защита
                <Tooltip>
                  Договор страхования жизни поможет защититься от финансовых рисков
                  и позволит значительно снизить ставку по кредиту. Оформляется
                  только по вашему желанию
                </Tooltip>
              </CheckBox>

              {(creditTitle === "Refenans") &&
                <CheckBox checked={creditCondition["extraMoneyCheckBox"]} checkChange={setCheckedOnExtraMoney}>
                  Я хочу получить дополнительные средства
                </CheckBox>
              }

              <CheckBox checked={creditCondition["ubrrCardAccount"]} checkChange={changeUbrrAccount}>
                Получаю зарплату на счет УБРиР
              </CheckBox>
              <Slider
                  mounthPayCalculate={mounthPayCalculate}
                  term={creditCondition["term"]}
                  maxsum={creditParameters["maxAmount"]}
                  minsum={creditParameters["minAmount"]}
                  financeProtection={creditCondition["financeProtection"]}
                  checkFinance={setCheckedOnFinanceProtection}
                  changeCreditSum={changeCreditSum}
                  creditSum={creditCondition["creditSum"]}
                  valueGradient={creditCondition["gradientValue"]}
                  creditTitle={creditTitle}
              />
              {
                (creditTitle === "Refenans") &&
                  <ExtraMoneyBox
                      maxsum={creditParameters["maxAmount"]}
                      extraMoneyCheckBox={creditCondition["extraMoneyCheckBox"]}
                      changeExtraMoneySum={changeExtraMoneySum}
                      creditSum={creditCondition["creditSum"]}
                      extraMoneySum={creditCondition["extraMoneySum"]}
                  />
              }
              <ListTerms
                  creditSum={creditCondition["creditSum"]}
                  term={creditCondition["term"]}
                  changeTerm={changeTerm}
                  termlist={creditParameters["termList"]}
              />
            </div>
            <MonthPay
                creditSum={creditCondition["creditSum"]}
                monthpay={creditCondition["monthPay"]}
                calculate={mounthPayCalculate}
                term={creditCondition["term"]}
                termlist={creditParameters["termList"]}
                stavka={creditCondition["percentRate"]}
                changeTerm={changeTerm}
                ubrrAccount={creditCondition["ubrrCardAccount"]}
                documents={creditCondition["documents"]}
            />
          </div>
        </div>
      </div>
  );
};
