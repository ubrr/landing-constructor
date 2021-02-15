import React from "react";
import '../styles/style.scss'

export const Tooltip = (props) => {
    return (
        <div className="symbol">
            ?<span className="tooltipText">{props.children}</span>
        </div>
    );
};
