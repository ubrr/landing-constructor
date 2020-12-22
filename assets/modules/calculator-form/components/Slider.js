import React from "react";
import '../styles/style.scss'

export const Slider = (props) => {
    const creditTitle = props.creditTitle;
    const creditSum = props.creditSum || 0;

    const changeSumOfCredit = function(event) {
        let val = parseInt(event.target.value.replace(/\D/g, ''));
        props.changeCreditSum(val);
    }

    const selectionOnFocus = (event) => {
        event.target.focus();
        event.target.select();
    }

    const checkInput = function(event){
        let val = parseInt(event.target.value.replace(/\D/g, ''));
        if (val < props.minsum) {
            props.changeCreditSum(props.minsum);
        }  else if(val > props.maxsum) {
            props.changeCreditSum(props.maxsum);
        }
    }

    const inputRunnerStyle = {
        background: 'linear-gradient(90deg,rgb(202,116,171) ' + ((creditSum - props.minsum) / (props.maxsum - props.minsum)) * 100 + '%, rgb(226,232,240)'
            + ((creditSum - props.minsum) / (props.maxsum - props.minsum)) * 100 + '%)'
    }

    return (
        <div className="sliderBox">
            <div className="sliderHeader">
                <div className="test1">
                    {(creditTitle === "Refenans") && "Сумма кредитов в других банках"}
                    {(creditTitle === "AnyPurpose" || creditTitle === "WithoutDoc") && "Сумма кредита"}
                </div>
                <div className="priceWrap">
                    <input
                        className="text2"
                        type="tel"
                        value={parseInt(props.creditSum).toLocaleString()}
                        onChange={changeSumOfCredit}
                        onFocus={selectionOnFocus}
                        onBlur={checkInput}
                        min={props.minsum}
                        max={props.maxsum}
                        step="5000"
                    />
                    <span style={{ marginTop: '1px' }}>₽</span>
                </div>

            </div>
            <input
                className="runner"
                style={inputRunnerStyle}
                onChange={changeSumOfCredit}
                type="range"
                min={props.minsum}
                max={props.maxsum}
                step="5000"
                value={props.creditSum || 0}
            />
        </div>
    );
};
