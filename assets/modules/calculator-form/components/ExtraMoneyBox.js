import React from "react";

export const ExtraMoneyBox = (props) => {
    const changeSumOfExtraMoney = function(event) {
        let val = parseInt(event.target.value.replace(/\D/g, ''));
        if (val > props.maxsum) {
            props.changeExtraMoneySum(props.maxsum - props.creditSum);
        } else if (val > 0) {
            props.changeExtraMoneySum(val);
        } else {
            props.changeExtraMoneySum(0);
        }
    }

    const selectionOnFocus = (event) => {
        event.target.focus();
        event.target.select();
    }

    const extraMoneyBoxWrapperStyle = {
        display: props.extraMoneyCheckBox ? '' : 'none'
    }

    return (
        <div style={extraMoneyBoxWrapperStyle}>
            <div className="inputHeader">Дополнительные средства на руки</div>
            <div className="priceWrap">
                <input
                    className="inputSum"
                    type="tel"
                    value={parseInt(props.extraMoneySum).toLocaleString()}
                    onChange={changeSumOfExtraMoney}
                    onFocus={selectionOnFocus}
                />
                <span style={{ marginTop: '1px', marginLeft: '5px' }}>₽</span>
            </div>
        </div>
    );
};
