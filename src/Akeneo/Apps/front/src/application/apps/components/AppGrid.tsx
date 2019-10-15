import * as React from 'react';
import {App as AppInterface} from '../../../domain/apps/app.interface';
import {FlowType} from '../../../domain/apps/flow-type.enum';
import {App} from './App';

export const AppGrid = () => {
    // const { result, error } = useFetch('');

    const apps: {[code: string]: AppInterface} = {
        AS_400: {code: 'AS_400', label: 'AS_400', flowType: FlowType.DATA_SOURCE},
        MagentoConnector: {code: 'MagentoConnector', label: 'Magento Connector', flowType: FlowType.DATA_DESTINATION},
        Google_Shopping: {code: 'Google_Shopping', label: 'Google Shopping', flowType: FlowType.DATA_DESTINATION},
        Bynder: {code: 'Bynder', label: 'Bynder DAM', flowType: FlowType.OTHERS},
    };

    return (
        <>
            {Object.values(apps).map(app => (
                <App code={app.code} label={app.label} key={app.code} />
            ))}
        </>
    );
};
