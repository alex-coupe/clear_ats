import React from 'react'
import App from '../components/App';
import { render} from '@testing-library/react';

test('App renders without crashing', () => {
    
    const component = render(<App />);
    expect(component).toBeTruthy();
});