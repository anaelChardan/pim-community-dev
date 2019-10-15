import * as React from 'react';
import styled from 'styled-components';

const StyledApp = styled.div`
    color: blue;
`;

interface Props {
    code: string;
    label: string;
}

export const App = ({code, label}: Props) => (
    <StyledApp onClick={() => console.log(code)}>
        <img src='#' alt={label} />
        <div>{label}</div>
    </StyledApp>
);
