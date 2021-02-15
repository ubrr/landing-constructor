import React from "react";
import '../styles/style.scss'

export const ListTerms = (props) => {
    const changeOption = (value) => {
        props.changeTerm(value);
    };

    const buttonStyle = (selected, disabled = false) => ({
        backgroundColor: disabled ? "#e9edf3" : selected ? "#d980b2" : "transparent",
        color: selected ? "white" : disabled ? "#848d94" : "black",
        border:  disabled ? "2px solid #e9edf3" : "2px solid #da81b3"
    });

    return (
        <div className="listTermsBox">
            <div className="listTermsText">На срок:</div>
            <div className="listTermsSelectionBox">
                {props.termlist.includes("2") && <button
                    className="listTermsButton"
                    style={buttonStyle(props.term === "2" )}
                    onClick={() => {
                        changeOption("2");
                    }}
                >
                    2 года
                </button>}
                <button
                    className="listTermsButton"
                    style={buttonStyle(props.term === "3")}
                    onClick={() => {
                        changeOption("3");
                    }}
                >
                    3 года
                </button>
                <button
                    className="listTermsButton"
                    style={buttonStyle(props.term === "5")}
                    onClick={() => {
                        changeOption("5");
                    }}
                >
                    5 лет
                </button>
                <button
                    className="listTermsButton"
                    style={buttonStyle(props.term === "7")}
                    onClick={() => {
                        changeOption("7");
                    }}
                >
                    7 лет
                </button>
                {props.termlist.includes("10") && <button
                    className="listTermsButton"
                    style={buttonStyle(props.term === "10", props.creditSum < 300000)}
                    disabled={props.creditSum < 300000}
                    onClick={() => {
                        changeOption("10");
                    }}
                >
                    10 лет
                </button>}
            </div>
        </div>
    );
};
