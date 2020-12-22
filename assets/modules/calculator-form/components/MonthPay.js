import React, { useState, useEffect } from "react";
import plus from "../plus.svg";
import minus from "../minusIcon.svg";
import '../styles/style.scss'

export const MonthPay = (props) => {
  const [disable, setdisable] = useState(false);
  useEffect(() => {
    if ((props.term === "7" && props.creditSum < 300000) || props.term === "10") {
      setdisable(true);
    } else setdisable(false);
    return () => {
      if ((props.term === "7" && props.creditSum < 300000) || props.term === "10") {
        setdisable(true);
      }
    };
  }, [props.creditSum, props.ubrrAccount, props.term]);

  const paymentDecrease = () => {
    let includindex = props.termlist.indexOf(props.term);

    if (includindex < 3) {
      props.changeTerm(props.termlist[includindex + 1]);
    } else if (includindex === 3 && props.creditSum > 300000) {
      props.changeTerm(props.termlist[includindex + 1]);
    }
  };

  const PaymentIncrease = () => {
    let includindex = props.termlist.indexOf(props.term);

    if (includindex > 0) {
      props.changeTerm(props.termlist[includindex - 1]);
    }
  };

  const divButtonPlusStyle = (disabled) => ({
    backgroundImage: disabled ? '' : 'url(' + plus + ')',
    pointerEvents: disabled ? 'none' : ''
  })

  const divButtonMinusStyle = (disabled) => ({
    pointerEvents: disabled ? 'none' : '',
    backgroundImage: disable ? "" : 'url(' + minus + ')',
  })

  return (
      <span className="blueBox">
        <div className="titleMonthPay">Ежемесячный платёж</div>
        <div className="inputPlusAndMinus">
          <div className="buttonMinus" style={divButtonMinusStyle(disable)} onClick={paymentDecrease} />
          <div className="input">
            {Math.round(props.monthpay).toLocaleString("ru-RU", {
              style: "currency",
              currency: "RUB",
              minimumFractionDigits: 0,
            })}
          </div>
          <div
              className="buttonPlus"
              style={divButtonPlusStyle(props.term === "2" || (props.term === "3" && props.termlist[0] === "3"))}
              onClick={PaymentIncrease}
              disabled={props.term === "2" || (props.term === "3" && props.termlist[0] === "3")}
          />
        </div>
        <div className="textRate">Ставка: {props.stavka}%</div>
        <div className="textDoc">Документы:</div>
        <div className="textMonthPay">— {props.documents[0]}</div>
        {/*TODO: Справка о даходах рендериться при загрузке*/}
        {props.documents[1] && <div className="textMonthPay">— {props.documents[1]}</div>}
      </span>
  );
};
