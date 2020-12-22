export const useParams = () => {
  const MaxCreditSumRefenans = 5000000;
  const MinCreditSumRefenans = 100000;
  const StavkaOfCreditRF = 6.5;

  const typeFromCalculator = {
    'anyPurpose': 'AnyPurpose',
    'withoutDoc': 'WithoutDoc',
    'refenans': 'Refenans'
  }

  const MaxCreditSumWithoutDoc = 300000;
  const MinCreditSumWithoutDoc = 15000;
  const StavkaOfCreditWD = 12;
  const termListWithoutDoc = ["3", "5", "7"];


  const MaxCreditSumAnyTarget = 5000000;
  const MinCreditSumAnyTarget = 50000;
  const StavkaOfCreditAT = 12;


  const defaultCreditSumWithoutDoc = 15000;
  const defaultCreditSumRefenans = 700000;
  const defaultExtraMoneySumRefenans = 0;
  const defaultCreditSumAnyPurpose = 50000;

  const termListRefinanse = ["3", "5", "7", "10"];
  const termListAnyPurpose = ["3", "5", "7", "10"];

  const creditWithoutDoc = {
    maxAmount: MaxCreditSumWithoutDoc,
    minAmount: MinCreditSumWithoutDoc,
    percentRate: StavkaOfCreditWD,
    termList: termListWithoutDoc,
    defaultCreditSum: defaultCreditSumWithoutDoc
  };

  const creditForAnyPurpose = {
    maxAmount: MaxCreditSumAnyTarget,
    minAmount: MinCreditSumAnyTarget,
    percentRate: StavkaOfCreditAT,
    termList: termListAnyPurpose,
    defaultCreditSum: defaultCreditSumAnyPurpose
  };
  const creditRefinancing = {
    maxAmount: MaxCreditSumRefenans,
    minAmount: MinCreditSumRefenans,
    percentRate: StavkaOfCreditRF,
    termList: termListRefinanse,
    defaultCreditSum: defaultCreditSumRefenans,
    defaultExtraMoneySum: defaultExtraMoneySumRefenans,
  };

  const getCreditParameters = (creditTitle) => {
    if (creditTitle === typeFromCalculator.anyPurpose) return creditForAnyPurpose;
    else if (creditTitle === typeFromCalculator.withoutDoc) return creditWithoutDoc;
    else return creditRefinancing;
  };

  return {
    getCreditParameters,
    typeFromCalculator
  };
};

